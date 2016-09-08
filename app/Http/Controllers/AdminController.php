<?php

namespace app\Http\Controllers;

use App\User;

use Auth;
use Hash;
use Validator;
use Input;
use Redirect;
use Response;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('admin', ['except' => 'getLogout']);
    // }

    public function index()
    {
        // profile user
        //return Redirect::action('AdminController@getEdit', array('id' => User::admin()->id));
        // list user
        return Redirect::action('AdminController@getList');
    }
    
    public function getLogout()
    {
        Auth::guard('admin')->logout();

        return redirect('admin');
    }


    // public function getLogin()
    // {
    //     if (!Auth::guard('admin')->check()) {
    //         return view('admin.login');
    //     } else {
    //         return "view('admin.master')";
    //         //return redirect('/admin/cate/list');
    //     }

    // }
    // public function getLogin()
    // {
    //     $auth = auth()->guard('admin');
    //     if (!$auth->check()) {
    //         return view('admin.login');
    //     } else {
    //         return redirect('admin');
    //     }
    // }

    // //public function postLogin(LoginRequest $re_login)
    // public function postLogin(Request $re_login)
    // {
    //     $rules = [
    //         'user' => 'required',
    //         'password' => 'required',
    //     ];

    //     $messages =
    //         ['user.required' => 'Vui lòng nhập Username',
    //             'password.required' => 'Vui lòng nhập Password',
    //         ];
    //     $validator = Validator::make($re_login->all(), $rules, $messages);

    //     if ($validator->fails()) {
    //         $result['_key'] = '_fail';
    //         $result['_info'] = $validator->errors();
    //     } else {
    //         $login = array(
    //             'username' => $re_login->input('user'),
    //             'password' => $re_login->input('password'),
    //             'level' => 1,
    //         );
    //         // $login = array(
    //         //     'username' => $re_login->user,
    //         //     'password' => $re_login->password,
    //         //     'level' => 1,
    //         // );
    //         // Request::input('txtIntro');
    //         // $login = array(
    //         //     'username' => Input::get('user'),
    //         //     'password' => Input::get('password'),
    //         //     'level' => 1,
    //         // );
    //         // if ($this->auth->attempt($login)) {
    //         //     return redirect()->route('admin.cate.list');
    //         // } else {
    //         //     return redirect()->back();
    //         // }
    //         //$auth = auth()->guard('admin');
    //         if (Auth::guard('admin')->attempt($login, $re_login->has('remember'))) {
    //             $result ['_url'] = route('admin.cate.list');
    //             $result ['_key'] = 'Oke';
    //             $result['info'] = 'Successfully logged in .... redirecting';
    //         } else {
    //             $result['_key'] = 'fail';
    //             $result['info'] = 'Username hoặc Password không đúng.';
    //         }
    //     }
    //     return Response::json($result);
    // }

    // public function getLogout()
    // {
    //     //Auth::logout();
    //     Auth::guard('user')->logout();
    //     //return redirect('admin');
    // }

    // public function postRegister(UserRegisterRequest $request)
    // {
    //     $result = array(
    //         'username' => $request->username,
    //         'email' => $request->email,
    //     );
    //     if ($this->auth->attempt($result)) {
    //         return redirect()->route('auth.register');
    //         // return redirect()->route('auth/register');
    //     }
    //     $result['level'] = 2;
    //     $result['password'] = Hash::make($request->password);

    //     // $this->auth->login($this->registrar->create($request->all()));
    //     $this->auth->login(Admin::create($result));

    //     return redirect($this->redirectPath());
    // }

    public function getAdd()
    {
        return view('admin.user.add');
    }

    public function postAdd(UserRequest $request)
    {
        $user = new User();
        $user->username = $request->txtUser;
        $user->password = Hash::make($request->txtPass);
        $user->email = $request->txtEmail;
        $user->level = $request->rdoLevel;
        $user->remember_token = $request->_token;
        $user->save();

        return redirect()
            ->route('admin.user.list')
            ->with(
                [
                    'co_level' => 'success',
                    'co_messages' => 'Đã thêm user thành công!',
                ]
            );
    }

    public function getList()
    {
        $_user = User::select('id', 'username', 'email', 'level')
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.user.list', compact('_user'));
    }

    public function getDelete($id)
    {
        $user_current_login = User::admin()->id;
        $user_current_level = User::admin()->level;
        $user = User::find($id); // user cần xóa
        // kiểm tra id truyền vào nếu id == id (superadmin) ko dk xoa or chinh supseradmin cung ko dk xoa
        if ($id == 1 || ($user_current_login != 1 && $user['level'] == 1)) {
            return redirect()
                ->route('admin.user.list')
                ->with(
                    [
                        'co_level' => 'danger',
                        'co_messages' => 'Xin lỗi!, Bạn không có quyền xóa user',
                    ]
                );
        } elseif ($user_current_level == 1) {    // la admin
            $user->delete($id);

            return redirect()
                ->route('admin.user.list')
                ->with(
                    [
                        'co_level' => 'success',
                        'co_messages' => 'Đã xóa user thành công',
                    ]
                );
        }//else{ // user member
        // 	echo "la member";
        // }
    }

    public function getEdit($id)
    {
        $data = User::findOrFail($id);

        return view('admin.user.edit', compact('data', 'id'));
    }

    public function postEdit($id, Request $_req)
    {
        $user = User::find($id);
        if ($_req->input('txtPass')) {
            $this->validate(
                $_req,
                [
                    'txtRePass' => 'same:txtPass',
                ],
                [
                    'txtRePass.same' => 'Hai mật khẩu không trùng nhau!',
                ]
            );
            $pass = $_req->input('txtPass');
            $user->password = Hash::make($pass);
        }

        $user->email = $_req->txtEmail;

        if ($_req->input('rdoLevel') != $user['level']) {
            if ((User::admin()->id != 1 && $user['level'] == 1) || $id == 1) {
                return redirect()
                    ->route('admin.user.list')
                    ->with(
                        [
                            'co_level' => 'danger',
                            'co_messages' => 'Xin lỗi!, Bạn không có quyền sửa user',
                        ]
                    );
            } else {
                $user->level = $_req->rdoLevel;
            }
        }

        $user->remember_token = $_req->input('_token');
        $user->save();

        return redirect()
            ->route('admin.user.list')
            ->with(
                [
                    'co_level' => 'success',
                    'co_messages' => 'Đã sửa user thành công',
                ]
            );
    }
}
