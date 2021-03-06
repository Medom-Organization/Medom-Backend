<?php

namespace Medom\Modules\Auth\Api\v1\Requests;

use Dingo\Api\Http\FormRequest;

class updateAccountRequest extends FormRequest
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
           'first_name'=>'required',
            'last_name'=>'required'
        ];
    }
}
