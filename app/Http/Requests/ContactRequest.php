<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ContactRequest extends Request
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
            'name' => 'required|min:4',
            'email' => 'required|regex:/^[a-z][a-z0-9]*(_[a-z0-9]+)*(\.[a-z0-9]+)*@[a-z0-9]([a-z0-9-][a-z0-9+)*(\.[a-z]{2,4}){1,2}$/',
            'title' => 'required|max:255',
            'message' => 'required|min:15',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'A title is required',
            'name.min' => 'Name min 4 character',
            'email.required' => 'Email is required',
            'email.regex' => 'We need to know your e-mail address!',
            'title.required' => 'A title is required',
            'title.max' => 'A title max 255 character',
            'message.required'  => 'A message is required',
            'message.min'  => 'A message min 15 character',
        ];
    }
}
