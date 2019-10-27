<?php

namespace Medom\Modules\Booking\Api\v1\Requests;

use Dingo\Api\Http\FormRequest;


class NewOrderRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'price_info' => 'required',
            // 'booking_reference' => 'required',
            // 'ticket_time_limit' => 'required',
            // 'total_travellers' => 'required',
            // 'traveller_stats' => 'required',
            // 'travellers' => 'required',
            // 'from' => 'required',
            // 'to' => 'required',
            // 'departure_city' => 'required',
            // 'destination_city' => 'required',
            // 'flight_info' => 'required',
            // 'departure_date' => 'required',
            // 'return_date' => 'required'
            'hospital_id' => 'required',
            'time' => 'required',
            'date' => 'required',
        ];
    }
}
