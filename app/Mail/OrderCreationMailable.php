<?php

namespace Medom\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Medom\Modules\Booking\Models\Order;
use Medom\Modules\Setting\Models\AmadeusAirline;

class OrderCreationMailable extends Mailable
{
    use Queueable, SerializesModels;
    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        $order = $this->order;
        $orderDetails["first_name"] = $order->first_name;
        $orderDetails["last_name"] = $order->last_name;
        $orderDetails["status"] = $order->status;
        $orderDetails["booking_date"] = Carbon::parse($order->created_at)->format("l, j F, Y");
        $orderDetails["booking_id"] =  $order->booking_id;
        $orderDetails["status"] = $order->status;
        $orderDetails["currency"] = $order->currency;
        $orderDetails["total"] = number_format($order->amount,2);



        //Outbound departure Flight details
     



        return $this
            ->view('mails.order2',["order"=>(object)$orderDetails])
            ->subject("Medom Order Confirmation");

    }
}
