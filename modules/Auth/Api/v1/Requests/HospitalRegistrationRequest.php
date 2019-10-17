<?php

namespace Medom\Modules\Auth\Api\v1\Requests;

use Dingo\Api\Http\FormRequest;

class HospitalRegistrationRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'hospitalname' => 'required',
            'hospitalemail' => 'required|email',
            'address' => 'required',
            'phone_no' => 'required',
            'certificate_no' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Provide a valid email address',
            'email.required' => 'Email is required',
            'password.required'  => 'Password is required'
            // 'email.unique' =>'Account already exists for the email provided, Login to add another company instead.',
            // 'password.required'  => 'Password is required to create your account',
            // 'first_name.required' => 'First Name is required',
            // 'last_name.required' => 'Last Name is required',
        ];
    }
}
