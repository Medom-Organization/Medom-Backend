<?php

namespace Medom\Modules\Blog\Api\v1\Requests;

// use Dingo\Api\Http\FormRequest;
use Illuminate\Foundation\Http\FormRequest;
class CreateBlogRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
            'category'=>'required',
            'tags.*'=>'required',
            'photo' => 'required',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
    // public function messages()
    // {
    //     return [
    //         'title.required' => 'title is required',
    //         'content.required'  => 'content is required',
    //         'content.unique' =>'content already exists'
    //     ];
    // }
}
