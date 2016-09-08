<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRegisterRequest extends Request {

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
			'username'              => 'required|max:255',
			//'password'              => 'required|max:255',
			'email'                 => 'required|email|unique:users,email',
			'password' => 'required|confirmed|min:6|max:60'
			//'password_confirmation' => 'required|confirmed|min:6|max:60'
		];
	}

	public function messages()
	{
		return [

		];
	}
}
