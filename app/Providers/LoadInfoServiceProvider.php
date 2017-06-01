<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\AppModel;
use App\Models\User;

class LoadInfoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $user = User::where('level', AppModel::ACCESS_SUPERADMIN_ACTION);
        if ($user->count() === 0) {
            $userIsResgister = null;
        }
        die('111');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

//http://giaphiep.com/docs/5.3/providers