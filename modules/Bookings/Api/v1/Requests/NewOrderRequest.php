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
            'hospital_id' => 'required',
            'time' => 'required',
            'date' => 'required',
        ];
    }
}