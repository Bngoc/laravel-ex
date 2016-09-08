<?php

namespace app\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'txtUser' => 'required|unique:users,username',
            'txtPass' => 'required',
            'txtRePass' => 'required|same:txtPass',
            'txtEmail' => 'required|unique:users,email|regex:/^[a-z][a-z0-9]*(_[a-z0-9]+)*(\.[a-z0-9]+)*@[a-z0-9]([a-z0-9-][a-z0-9+)*(\.[a-z]{2,4}){1,2}$/',
        ];
    }

    public function messages()
    {
        return [
            'txtUser.required' => 'Vui lòng nhập tên.',
            'txtUser.unique' => 'Tên đã tồn tại',
            'txtPass.required' => 'Vui lòng nhập mật khẩu',
            'txtRePass.required' => 'Vui lòng nhập lại mật khẩu',
            'txtRePass.same' => 'Hai mật khẩu không trùng nhau',
            'txtEmail.required' => 'Vui lòng nhập email',
            'txtEmail.regex' => 'Địa chỉ email không hợp lệ',
            'txtEmail.unique' => 'Email đã tồn tại',
        ];
    }
}
