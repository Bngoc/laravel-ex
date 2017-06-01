<?php

namespace app\Http\Controllers\Admin;

use App\Models\Admin;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Input;
use Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AppModel;

class AuthController extends Controller
{
    
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/admin/dashboard';
    //protected $guard = 'admin';

    //public function __construct(Guard $auth, Registrar $registrar)
    public function __construct()
    {
        //$this->auth = $auth;
        //$this->registrar = $registrar;
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->middleware(['guest'], ['except' => 'getLogout']);
        //$this->middleware(['web'], ['except' => 'getLogout']);
    }

    public function getLogin()
    {
        if (Auth::guard('admin')->check()) {
            return \Redirect::route('admin.dashboard');
        } else {
            return view('admin.login');
        }
    }

    //public function postLogin(LoginRequest $re_login)
    public function postLogin(Request $re_login)
    {
        $rules = [
            'user' => 'required',
            'password' => 'required',
        ];

        $messages =
            [
                'user.required' => 'Vui lòng nhập Username',
                'password.required' => 'Vui lòng nhập Password',
            ];
        $validator = Validator::make($re_login->all(), $rules, $messages);

        if ($validator->fails()) {
            $result['_key'] = '_fail';
            $result['_info'] = $validator->errors();
        } else {
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
                'username' => Input::get('user'),
                'password' => Input::get('password'),
                'level' => AppModel::ACCESS_SUPERADMIN_ACTION,
            );

            // if (Auth::guard('web')->attempt($login)) {
            //     return redirect()->route('admin.cate.list');
            // } else {
            //     return redirect()->back();
            // }
            if (Auth::guard('admin')->attempt($login, $re_login->has('remember'))) {
                $result ['_url'] = route('admin.dashboard');
//                $result ['_url'] = URL('admin/cate/list');
                $result ['_key'] = 'Oke';
                $result['info'] = 'Successfully logged in .... redirecting';
            } else {
                $result['_key'] = 'fail';
                $result['info'] = 'Username hoặc Password không đúng.';
            }
        }

        return Response::json($result);

         // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        // if ($throttles && ! $lockedOut) {
        //     $this->incrementLoginAttempts($request);
        // }

        // return $this->sendFailedLoginResponse($request);
    }

    public function postRegister(UserRegisterRequest $request)
    {
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
