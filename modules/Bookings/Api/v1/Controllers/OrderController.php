<?php

namespace Travellab\Modules\Booking\Api\v1\Controllers;

use Illuminate\Http\Request;
use Travellab\Modules\Auth\Api\v1\Transformers\UserTransformer;
use Travellab\Modules\BaseController;
use Travellab\Modules\Booking\Api\v1\Repositories\OrderRepository;
use Travellab\Modules\Booking\Api\v1\Transformers\OrderTransformer;
use Travellab\Modules\Booking\Api\v1\Requests\FilterOrderRequest;

class OrderController extends BaseController
{

    public function __construct(OrderRepository $orderRepo, OrderTransformer $orderTransformer, UserTransformer $userTransformer)
    {
        $this->orderRepo = $orderRepo;
        $this->orderTransformer = $orderTransformer;
        $this->userTransformer = $userTransformer;
    }

    public function newOrder(Request $request)
    {

        $order = $this->orderRepo->create($request);

        $orderDetails = $this->transformModel($order->order, $this->orderTransformer);
        $userDetails["user"] = $this->transformModel($order->user, $this->userTransformer);
        $userDetails["token"] = auth()->login($order->user);

        return $this->success(["order_details" => $orderDetails, "user_details" => $userDetails]);
    }
    public function listOrders()
    {
        $orders = $this->orderRepo->list();
        return $this->transform($orders, $this->orderTransformer);
    }
    public function listOrdersbyUserId($id)
    {
        $orders = $this->orderRepo->listbyUserId($id);
        return $this->transform($orders, $this->orderTransformer);
    }
    public function listOrdersbyId($id)
    {
        $orders = $this->orderRepo->listbyId($id);
        return $this->transform($orders, $this->orderTransformer);
    }
    public function listOrdersbyUser(OrderTransformer $transformer)
    {
        $user = $this->orderRepo->listOrdersbyUser();
        return $user;
    }
    public function filterorderbyUser(FilterOrderRequest $request)
    {
        $status = explode(',', $request->get('status'));
        $user = $this->orderRepo->filterorderbyUser($request->all(), $status);
        return $user;
    }

    public function newPayment(Request $request)
    {
        return $payment = $this->orderRepo->newPayment($request);
        // return $this->transform($order,$this->orderTransformer);

    }

    public function verifyPayment($reference)
    {

        return $this->orderRepo->verifyPayment($reference);
    }

    public function createTicket(Request $request)
    {
        $this->validate($request, [
            'travellers' => 'required',
            'pnr' => 'required',
        ]);

        $ticket = $this->orderRepo->createTicket($request);

        return $ticket;
    }

    public function sendTicket(Request $request, $ref)
    {
        return $this->success($this->orderRepo->sendTicketEmail($ref));
    }

    public function confirmBooking(Request $request, $orderId)
    {
        return $this->orderRepo->confirmBooking($orderId);
    }

    public function allPayment(OrderTransformer $transformer)
    {
        $payment = $this->orderRepo->allPayment();
        return $this->successWithPages($payment, $transformer);
    }
}
