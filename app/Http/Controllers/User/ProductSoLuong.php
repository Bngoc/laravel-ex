<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductSoLuong extends Controller
{
    protected $tabe = 'product_soluongs';
    protected $fillabe = ['id', 'color_id', 'size_id', 'product_id', 'soluong'];
    public $timestamps = true;
}
