<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $tabe = 'products';
    protected $fillabe = ['name', 'alias', 'price', 'intro', 'content', 'image', 'keywords', 'description', 'user_id', 'cate_id'];
    public $timestamps = true;

    public function cate()
    {
        return $this->belongsTo('App\Cate', 'cate_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Admin');
    }

    public function pimage()
    {
        return $this->hasMany('App\ProductImage');
    }
    public function productcolor()
    {
        return $this->hasMany('App\User\ProductColor');
    }
    public function productsize()
    {
        return $this->hasMany('App\User\ProductSize');
    }
    public function productsoluong()
    {
        return $this->hasMany('App\User\ProductCount');
    }
}
