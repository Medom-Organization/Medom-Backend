<?php

namespace Medom\Modules\Bookings\Api\v1\Requests;

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
            // ''
            'symptoms' => 'required',
            'booking_type' => 'required',
            'hospital_id' => 'required',
            'description'=>'required',
            'time' => 'required',
            'date' => 'required',
        ];
    }
}
