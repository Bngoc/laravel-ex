<?php

namespace app;

use Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'password', 'email', 'level'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $guard = "admins";

    public function product()
    {
        return $this->hasMany('App\Product');
    }

    protected static function admin()
    {
        if (Auth::guard('admin')->check()) {
            $_admin = Auth::guard('admin')->user();
            $person = (object) [
                'id' => $_admin->id,
                'username' => $_admin->username,
                'password' => $_admin->password,
                'email' => $_admin->email,
                'level' => $_admin->level,
                'remember_token' => $_admin->remember_token,
                'created_at' => $_admin->created_at,
                'updated_at' => $_admin->updated_at,
            ];
        } else {
            return false;
        }

        return $person;
    }
    protected static function user()
    {
         // if (Auth::guard('admin')->check())
        $_user = Auth::guard('web')->user();
        $obj = (object) [
            'id' => $_user->id,
            'username' => $_user->username,
            'password' => $_user->password,
            'email' => $_user->email,
            'level' => $_user->level,
            'remember_token' => $_user->remember_token,
            'created_at' => $_user->created_at,
            'updated_at' => $_user->updated_at,
        ];
        return $obj;
    }
}
