<?php

namespace app\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use Auth;
use Hash;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Input;
use Response;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    //? ??? day
    //protected $loginPath = '/login';
    protected $redirectTo = '/';
    //protected $redirectAfterLogout = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     * @param \Illuminate\Contracts\Auth\Registrar $registrar
     */
    public function __construct(Guard $auth, Registrar $registrar)
    {
        $this->auth = $auth;
        $this->registrar = $registrar;

        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function getLogin()
    {
        if (Auth::guard('web')->check()) {
            return view('user.master');
        } else {
            return view('auth/login');
        }

        //return view('auth/login');
    }

    //public function postLogin(LoginRequest $re_login)
    public function postLogin(Request $re_login)
    {
        // $rules = [
        //     'user' => 'required',
        //     'password' => 'required',
        // ];

        // $messages =
        //     ['user.required' => 'Vui lòng nhập Username',
        //         'password.required' => 'Vui lòng nhập Password',
        //     ];
        // $validator = Validator::make($re_login->all(), $rules, $messages);

        //if ($validator->fails()) {
        //    $result['_key'] = '_fail';
        //    $result['_info'] = $validator->errors();
        //} else {
        // $login = array(
        //     'username' => $re_login->input('user'),
        //     'password' => $re_login->input('password'),
        //     'level' => 1,
        // );
        // $login = array(
        //     'username' => $re_login->user,
        //     'password' => $re_login->password,
        //     'level' => 1,
        // );
        // Request::input('txtIntro');

        $login = array(
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            //'level' => 1,
        );
        if (Auth::guard('web')->attempt($login, $re_login->has('remember'))) {
            //return redirect()->route('/home');
            return view('user.master');
        } else {
            return redirect()->back();
        }

        // if ($this->auth->attempt($login)) {
        //     $result ['_url'] = route('admin.cate.list');
        //     $result ['_key'] = 'Oke';
        //     $result['info'] = 'Successfully logged in .... redirecting';
        // } else {
        //     $result['_key'] = 'fail';
        //     $result['info'] = 'Username hoặc Password không đúng.';
        // }
        //}

        //return Response::json($result);
    }

    public function getLogout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }

    public function postRegister(UserRegisterRequest $request)
    {
        dd($request);
        $result = array(
            'username' => $request->username,
            'email' => $request->email,
        );
        if ($this->auth->attempt($result)) {
            return redirect()->route('auth.register');
            // return redirect()->route('auth/register');
        }
        $result['level'] = 2;
        $result['password'] = Hash::make($request->password);

        // $this->auth->login($this->registrar->create($request->all()));
        $this->auth->login(Admin::create($result));

        return redirect($this->redirectPath());
    }
}
