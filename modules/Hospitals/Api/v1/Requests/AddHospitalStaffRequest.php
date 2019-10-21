<?php
namespace Medom\Modules\Hospitals\Api\v1\Requests;

use Dingo\Api\Http\FormRequest;

class AddHospitalStaffRequest extends FormRequest
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
            'hospitalname' => 'required',
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
