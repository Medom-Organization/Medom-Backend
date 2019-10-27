<?php

namespace Medom\Modules\Booking\Api\v1\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Medom\Mail\OrderCreationMailable;
use Medom\Modules\Auth\Api\v1\Repositories\AuthRepository;
use Medom\Modules\BaseRepository;
use Medom\Modules\Booking\Models\Order;
use Medom\Modules\Booking\Models\Payment;

class OrderRepository extends BaseRepository
{
    private $orderModel;
    private $authRepo;

    public function __construct()
    {
        $this->orderModel = new Order;
        $this->authRepo = new AuthRepository;
    }

    public function create($data)
    {
        $order = $this->orderModel->where(['booking_reference' => $data->booking_reference])->first();
        $email = $data->travellers[0]['email'];
        $user = $this->authRepo->getUserByEmail($email);

        if (!$order) {
            $order = Order::create([
                'booking_id' => $this->generateBookingId(),
                'price_info' => $data->price_info,
                'surname' => $data->travellers[0]['surname'],
                'first_name' => $data->travellers[0]['first_name'],
                'email' => $data->travellers[0]['email'],
                'phone' => $data->travellers[0]['phone'],
                'amount' => $data->price_info['ItinTotalFare']['TotalFare']['_attributes']['Amount'],
                'currency' => $data->price_info['ItinTotalFare']['TotalFare']['_attributes']['Currency'],
                'status' => 'pending payment',
                'user_id' => $user->id,
                'hospital_id'=>$data->hospital_id,
                'date'=>$data->date,
                'time'=>$data->time,
            ]);
        }

        $this->sendOrderCreationEmail($order);

        return (object) ["order" => $order, "user" => $user];
    }

    public function newPayment($data)
    {
        $order = Order::find($data->order_id);

        if (!$order) {
            abort(404, "Order not found");
        }

        $checkPayment = Payment::where(['order_id' => $data->order_id, 'status' => 'success'])->first();

        if ($checkPayment) {
            return $checkPayment;
        }

        $checkPendingPayment = Payment::where(['order_id' => $data->order_id, 'status' => 'pending'])->first();

        if (!$checkPendingPayment) {
            $payment = Payment::create([
                'order_id' => $data->order_id,
                'amount' => $order->amount,
                'currency' => $order->currency,
                'reference' => date("ymd") . str_random(10),
                'user_id' => $order->user_id,
                'name' => $order->first_name . " " . $order->surname,
                'status' => 'pending',
            ]);
        } else {
            $payment = $checkPendingPayment;
        }

        return $payment;
    }

    function list()
    {

        return Order::all();
    }
    public function listbyUserId($id)
    {
        return Order::where('user_id', $id)->get();
    }
    public function listbyId($id)
    {
        $user = auth()->user();
        return Order::where('_id', $id)->where('user_id', $user->id)->get();
    }

    public function generateBookingId()
    {
        return date('ymd') . rand(000000, 999999);
    }

    public function verifyPayment($reference)
    {
        $pendingPayment = Payment::where(['reference' => $reference, 'status' => 'pending'])->first();

        if (!$pendingPayment) {
            abort(404, "Payment not initialized");
        }

        $http = new Client();
        try {

            $response = $http->request("get", env('PAYSTACK_BASEURL') . 'transaction/verify/' . $reference, [
                "headers" => [
                    "Authorization" => "Bearer " . env("PAYSTACK_SECRET_KEY"),
                ],
            ]);

            $paymentData = json_decode($response->getBody()->getContents());

            if ($paymentData->status) {

                if ($paymentData->data->status === 'success') {
                    $this->updatePayment($reference, $paymentData->data);
                    $this->updateOrder($reference);
                }

                $data = [
                    "status" => "success",
                    "data" => [
                        "status" => $paymentData->data->status,
                        "reference" => $paymentData->data->reference,
                        "amount" => $paymentData->data->amount,
                        "order" => $pendingPayment->order,
                        "transaction_date" => $paymentData->data->transaction_date,
                    ],

                ];

                return response()->json($data);
            } else {
                return response()->json(["message" => "Payment data not found"]);
            }
        } catch (GuzzleException $e) {
            return response()->json(["message" => "unable to verify transactions "], 400);
        }
    }


    public function confirmBooking($orderId)
    {
        $order = Order::find($orderId);

        if ($order) {
            $order->status = 'confirmed';
            $order->save();
            $this->sendTicketEmail($order);

            return response()->json(["status" => "success", "message" => "Booking confirmed"]);
        }

        return response()->json(['status' => 'error', 'message' => "booking could not be confirmed"]);
    }




    public function updatePayment($reference, $data)
    {
        $payment = Payment::where("reference", $reference)->first();

        if ($payment) {
            $payment->status = "success";
            $payment->transaction_date = $data->transaction_date;
            $payment->details = $data;
            $payment->save();
        }

        return $payment;
    }

    public function updateOrder($reference)
    {
        $payment = Payment::where(['reference' => $reference])->first();

        $order = Order::find($payment->order_id);
        $order->status = "Pending create ticket";
        $order->save();

        return $order;
    }

    public function sendOrderCreationEmail(Order $order)
    {

        try {
            Mail::to($order->email)->later(now()->addSecond(5), new OrderCreationMailable($order));

            if (count(Mail::failures()) < 1) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            print $e->getMessage();

            return false;
        }
    }

    public function listOrdersbyUser()
    {
        $user = auth()->user();
        $order = $this->orderModel->where('user_id', $user->id)->get();
        return $order;
    }
    public function allPayment(Request $request)
    {
        $user = auth()->user();
        return Payment::where('user_id', $user->_id)->paginate(10);
    }
    private function stripExtraCharaters()
    { }
    public function filterorderbyUser($request, $status)
    {
        $result = $this->orderModel->where('from', $request['from'])->where('to', $request['to'])->where('status', $status[0])->orWhere('status', $status[0])->get();
        return $result;
    }
}
