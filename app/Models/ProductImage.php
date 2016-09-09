<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $tabe = 'product_images';
    protected $fillabe = ['image', 'product_id'];
    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
