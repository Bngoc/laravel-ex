<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // public function getAdd()
    // {
    //     return view('admin.user.add');
    // }

    // public function postAdd(UserRequest $request)
    // {
    //     $user = new User();
    //     $user->username = $request->txtUser;
    //     $user->password = Hash::make($request->txtPass);
    //     $user->email = $request->txtEmail;
    //     $user->level = $request->rdoLevel;
    //     $user->remember_token = $request->_token;
    //     $user->save();

    //     return redirect()
    //         ->route('admin.user.list')
    //         ->with(
    //             [
    //                 'co_level' => 'success',
    //                 'co_messages' => 'Đã thêm user thành công!'
    //             ]
    //         );
    // }

    // public function getList()
    // {
    //     $_user = User::select('id', 'username', 'email', 'level')
    //         ->orderBy('id', 'DESC')
    //         ->get();

    //     return view('admin.user.list', compact('_user'));
    // }

    // public function getDelete($id)
    // {
    //     $user_current_login = Auth::user()->id;
    //     $user_current_level = Auth::user()->level;
    //     $user = user::find($id); // user cần xóa
    //     // kiểm tra id truyền vào nếu id == id (superadmin) ko dk xoa or chinh supseradmin cung ko dk xoa
    //     if ($id == 1 || ($user_current_login != 1 && $user['level'] == 1)) {

    //         return redirect()
    //             ->route('admin.user.list')
    //             ->with(
    //                 [
    //                     'co_level' => 'danger',
    //                     'co_messages' => 'Xin lỗi!, Bạn không có quyền xóa user'
    //                 ]
    //             );
    //     } elseif ($user_current_level == 1) {    // la admin
    //         $user->delete($id);

    //         return redirect()
    //             ->route('admin.user.list')
    //             ->with(
    //                 [
    //                     'co_level' => 'success',
    //                     'co_messages' => 'Đã xóa user thành công'
    //                 ]
    //             );
    //     }//else{ // user member
    //     // 	echo "la member";
    //     // }
    // }

    // public function getEdit($id)
    // {
    //     $data = user::findOrFail($id);

    //     return view('admin.user.edit', compact('data', 'id'));
    // }

    // public function postEdit($id, Request $_req)
    // {
    //     $user = user::find($id);
    //     if ($_req->input('txtPass')) {
    //         $this->Validate(
    //             $_req,
    //             [
    //                 'txtRePass' => 'same:txtPass'
    //             ],
    //             [
    //                 'txtRePass.same' => 'Hai mật khẩu không trùng nhau!'
    //             ]
    //         );
    //         $pass = $_req->input('txtPass');
    //         $user->password = Hash::make($pass);
    //     }

    //     $user->email = $_req->txtEmail;

    //     if ($_req->input('rdoLevel') != $user['level']) {
    //         if ((Auth::user()->id != 1 && $user['level'] == 1) || $id == 1) {
    //             return redirect()
    //                 ->route('admin.user.list')
    //                 ->with(
    //                     [
    //                         'co_level' => 'danger',
    //                         'co_messages' => 'Xin lỗi!, Bạn không có quyền sửa user'
    //                     ]
    //                 );
    //         } else {
    //             $user->level = $_req->rdoLevel;
    //         }
    //     }

    //     $user->remember_token = $_req->input('_token');
    //     $user->save();

    //     return redirect()
    //         ->route('admin.user.list')
    //         ->with(
    //             [
    //                 'co_level' => 'success',
    //                 'co_messages' => 'Đã sửa user thành công'
    //             ]
    //         );
    // }
}
