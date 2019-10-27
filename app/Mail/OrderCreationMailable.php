<?php

namespace Travellab\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Travellab\Modules\Booking\Models\Order;
use Travellab\Modules\Setting\Models\AmadeusAirline;

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
        $orderDetails["booking_ref"] = $order->booking_reference["id"];
        $orderDetails["status"] = $order->status;
        $orderDetails["currency"] = $order->currency;
        $orderDetails["total"] = number_format($order->amount,2);
        $orderDetails["from_city"] = $order->from["city"];
        $orderDetails["to_city"] =  $order->to["city"];



        //Outbound departure Flight details
        $orderDetails["outbound_airline"] = AmadeusAirline::where("code",$order->departure_leg["airline"])->first()->name;
        $orderDetails["outbound_flight_no"] = $order->departure_leg["flightSegment"][0]["flightNumber"];

        $orderDetails["out_depart_date"] = Carbon::parse($order->departure_leg["flightSegment"][0]["departureTime"])->format('d F, Y');
        $orderDetails["out_depart_time"] =  Carbon::parse($order->departure_leg["flightSegment"][0]["departureTime"])->format('H:i');
        $orderDetails["out_depart_airport"] = $order->from["name"].'-'.$order->from['city_name'];


        //Outbound arrival Flight details
        $orderDetails["out_arrival_date"] = Carbon::parse($order->departure_leg["flightSegment"][0]["arrivalTime"])->format('d F, Y');
        $orderDetails["out_arrival_time"] = Carbon::parse($order->departure_leg["flightSegment"][0]["arrivalTime"])->format('H:i');
        $orderDetails["out_arrival_airport"] = $order->to["name"].'-'.$order->to['city_name'];



        //Inbound departure flight details
        $orderDetails["inbound_airline"] = AmadeusAirline::where("code",$order->return_leg["airline"])->first()->name;
        $orderDetails["inbound_flight_no"] = $order->return_leg["flightSegment"][0]["flightNumber"];


        $orderDetails["in_depart_date"] = Carbon::parse($order->return_leg["flightSegment"][0]["departureTime"])->format('d F, Y');
        $orderDetails["in_depart_time"] =  Carbon::parse($order->return_leg["flightSegment"][0]["departureTime"])->format('H:i');
        $orderDetails["in_depart_airport"] = $order->to["name"].'-'.$order->to['city_name'];

        //Inbound arrival flight details
        $orderDetails["in_arrival_date"] = Carbon::parse($order->return_leg["flightSegment"][0]["arrivalTime"])->format('d F, Y');
        $orderDetails["in_arrival_time"] = Carbon::parse($order->return_leg["flightSegment"][0]["arrivalTime"])->format('H:i');
        $orderDetails["in_arrival_airport"] = $order->from["name"].'-'.$order->from['city_name'];



        return $this
            ->view('mails.order2',["order"=>(object)$orderDetails])
            ->subject("Travellab Order Confirmation");

    }
}
