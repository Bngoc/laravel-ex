<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $tabe = 'product_sizes';
    protected $fillabe = ['id', 'namesize', 'product_id'];
    public $timestamps = true;

    public function size_product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
    public function size_soluong()
    {
        return $this->hasMany('App\Models\User\ProductCount', 'size_id');
    }
}
