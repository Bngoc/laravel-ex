<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $tabe = 'product_colors';
    protected $fillabe = ['id', 'namecolor', 'product_id'];
    public $timestamps = true;

    public function color_product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
    public function color_soluong()
    {
        return $this->hasMany('App\User\ProductCount', 'color_id');
    }
}
