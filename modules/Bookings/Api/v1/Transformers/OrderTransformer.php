<?php

namespace Medom\Modules\Bookings\Api\v1\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Medom\Modules\Booking\Models\Order;

class OrderTransformer extends TransformerAbstract
{

    public function transform(Order $order)
    {
        return [
            'id' => $order->_id,
            'first_name' => $order->first_name,
            'surname' => $order->surname,
            'email' => $order->email,
            'phone' => $order->phone,
            'order_date' => date('Y-m-d', strtotime($order->created_at)),
            'departure_date' => $order->departure_date,
            'from' => $order->from,
            'to' => $order->to,
            'departure_city' => $order->departure_city,
            'return_date' => $order->return_date ? $order->return_date : null,
            'destination_city' => $order->destination_city,
            'time_limit' => $order->ticket_time_limit,
            'travellers' => $order->travellers,
            'price_info' => $order->price_info,
            'amount' => $order->amount,
            'currency' => $order->currency,
            'status' => $order->status,
            'flight' => $order->flight,
            'booking_id' => $order->booking_id,
            'booking_reference' => $order->booking_reference,
        ];
    }
}
