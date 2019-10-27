<?php

namespace Travellab\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Travellab\Models\City;
use Travellab\Modules\Booking\Models\Order;
use PDF;
use Travellab\Modules\Flight\Models\AircraftCode;
use Travellab\Modules\Setting\Models\AmadeusAirline;
use Travellab\Modules\Setting\Models\AmadeusAirport;

class FlightTicketMailable extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $ticketPdf;

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





        ///////////////////////////////////////////////////
        /// Ticket Pdf Files ///////////////////////
        /// ///////////////////////////


        $ticket["issue_date"] = Carbon::parse($order->created_at)->format('l, j F, Y');
        $ticket["status"] = $order->status;
        $ticket["booking_ref"] = $order->booking_reference["id"];

        $ticket["travellers"]  = collect($order->travellers)->map(function ($traveller){
            if(is_array($traveller))
                $traveller = (object)$traveller;
            return $traveller->title." ".$traveller->first_name." ".$traveller->surname." (".$traveller->label.")";
        });

        $ticket["outbound_from_to"] = $order->from['city_name']." to ".$order->to['city_name'];


        $ticket["outbound_itinerary"] = collect($order->departure_leg["flightSegment"])->map(function($segment)use ($order){
            if(is_array($segment))
                $segment = (object)$segment;
            $data["date"] = Carbon::parse($segment->departureTime)->format('l, j F, Y');


            $from = AmadeusAirport::where("code",$segment->departureAirport["LocationCode"])->first();
            $to = AmadeusAirport::where("code",$segment->arrivalAirport["LocationCode"])->first();



            $data["from"] = $from->city->name;
            $data["to"]= $to->city->name;


            $airline = AmadeusAirline::where("code",$segment->airline)->first();
            $data["airway"] = $airline->name." ".$segment->airline." ".$segment->flightNumber;
            $data["departure_date"] = Carbon::parse($segment->departureTime)->format(' j F, Y H:i');
            $data["arrival_date"] = Carbon::parse($segment->arrivalTime)->format(' j F, Y H:i');
            $data["departure_airport"] = AmadeusAirport::where("code",$segment->departureAirport["LocationCode"])->first()->name. ' - '.$from->city->name;


            $arrivalAirport = AmadeusAirport::where("code",$segment->arrivalAirport["LocationCode"])->first();



            $data["arrival_airport"] =$arrivalAirport->name. ' - '.$to->city->name;



            $data["flying_time"] = $segment->duration;
            $data["status"] = $order->status;
            $data["aircraft"] =  AircraftCode::where("iata_code",$segment->flightNumber)->first();
            return (object) $data;


        });





        $ticket["inbound_from_to"] = $order->to['city_name']." to ".$order->from['city_name'];

        $ticket["inbound_itinerary"] = collect($order->return_leg["flightSegment"])->map(function($segment)use ($order){
            if(is_array($segment))
                $segment = (object)$segment;
            $data["date"] = Carbon::parse($segment->departureTime)->format('l, j F, Y');


            $from = AmadeusAirport::where("code",$segment->departureAirport["LocationCode"])->first();
            $to = AmadeusAirport::where("code",$segment->arrivalAirport["LocationCode"])->first();
            $data["from"] = $from->city->name;
            $data["to"]= $to->city->name;


            $airline = AmadeusAirline::where("code",$segment->airline)->first();
            $data["airway"] = $airline->name." ".$segment->airline." ".$segment->flightNumber;
            $data["departure_date"] = Carbon::parse($segment->departureTime)->format(' j F, Y H:i');
            $data["arrival_date"] = Carbon::parse($segment->arrivalTime)->format(' j F, Y H:i');
            $data["departure_airport"] = AmadeusAirport::where("code",$segment->departureAirport["LocationCode"])->first()->name. '- '.$from->city->name;
            $data["arrival_airport"] = AmadeusAirport::where("code",$segment->arrivalAirport["LocationCode"])->first()->name. '- '.$to->city->name;
            $data["flying_time"] = $segment->duration;
            $data["status"] = $order->status;
            $data["aircraft"] =  AircraftCode::where("iata_code",$segment->flightNumber)->first();
            return (object) $data;

        });


        $pdf = PDF::loadView('mails.booking', ["ticket"=>(object)$ticket]);
        $ticketPDF =  $pdf->output();









        ///////////////////////////////////////////////////////////////////////////////////////////
        /// Mail template data //////////////////////////////
        /////////////////////////////////////////////////////

        $orderDetails["first_name"] = $order->first_name;
        $orderDetails["last_name"] = $order->last_name;
        $orderDetails["status"] = $order->status;
        $orderDetails["booking_date"] = Carbon::parse($order->created_at)->format("l, j F, Y");
        $orderDetails["booking_id"] =  $order->booking_id;
        $orderDetails["booking_ref"] = $order->booking_reference["id"];
        $orderDetails["status"] = $order->status;
        $orderDetails["currency"] = $order->currency;
        $orderDetails["total"] = number_format($order->amount,2);;
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






        //Now Sending mail
        return $this->view('mails.order',["order"=>(object)$orderDetails])
            ->subject("Travellab Flight Ticket")
            ->attachData($ticketPDF,"Flight Ticket.pdf",[
                'mime' => 'application/pdf',
            ]);
    }





}
