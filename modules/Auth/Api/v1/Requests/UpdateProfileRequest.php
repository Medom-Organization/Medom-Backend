<?php

namespace Medom\Modules\Auth\Api\v1\Requests;

use Dingo\Api\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'phone_no'=>'required',
            'marital_status'=>'required',
            'DOB'=>'required',
            'address'=>'required',
            'genotype'=>'required',
            'blood_group'=>'required',
            'height'=>'required',
            'weight'=>'required',
            'religion'=>'required',
            'next of kin'=>'required',
            // 'height'=>'required',
            // 'weight'=>'required'
        ];
    }
}
