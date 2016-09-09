<?php

namespace app\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class Admin extends Authenticatable
{
    protected $tabe = 'admins';
    protected $fillable = ['username', 'password', 'email', 'level'];
    public $timestamps = true;
    protected $hidden = ['password', 'remember_token'];

    public function product()
    {
        return $this->hasMany('App\Models\Product');
    }

    // protected static function auth()
    // {
    //     $_admin = Auth::guard('admin')->user();
    //     $person = (object) [
    //         'id' => $_admin->id,
    //         'username' => $_admin->username,
    //         'password' => $_admin->password,
    //         'email' => $_admin->email,
    //         'level' => $_admin->level,
    //         'remember_token' => $_admin->remember_token,
    //         'created_at' => $_admin->created_at,
    //         'updated_at' => $_admin->updated_at,
    //     ];
    //     return $person;
    // }

    // protected static function logout()
    // {
    //     Auth::guard('admin')->logout();

    //     return redirect('admin/login');
    // }
}
