<?php

namespace app\Http\Requests;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
            'user' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user.required' => 'Vui lòng nhập Username',
            'password.required' => 'Vui lòng nhập Password',
        ];
    }
}
