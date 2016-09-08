<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

class ProductCount extends Model
{
    protected $tabe = 'product_counts';
    protected $fillabe = ['id', 'color_id', 'size_id', 'product_id', 'soluong'];
    public $timestamps = true;

    public function soluong_size()
    {
        return $this->belongsTo('App\User\ProductSize', 'size_id');
    }
    public function soluong_color()
    {
        return $this->belongsTo('App\User\ProductColor', 'color_id');
    }
    public function soluong_product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
