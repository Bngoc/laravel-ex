<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{
    const ACCESS_SUPERADMIN_ACTION = 1;
    const ACCESS_ADMIN_ACTION = 2;
    const ACCESS_MEMBER_ACTION = 3;
    const is_ADMIN = 1;

    public static $statuses = [
        self::ACCESS_SUPERADMIN_ACTION => 'SuperAdmin',
        self::ACCESS_ADMIN_ACTION => 'Admin',
        self::ACCESS_MEMBER_ACTION => 'Member'
    ];
}
