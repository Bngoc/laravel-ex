<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MustHave extends Model
{
    protected $tabe = 'must_haves';
    protected $fillabe = ['id', 'name', 'image', 'user_id', 'path', 'product_id'];
    public $timestamps = true;
}
