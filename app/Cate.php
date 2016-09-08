<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    protected $tabe = 'cates';
    protected $fillabe = ['name', 'alias', 'oder', 'parent_id', 'keywords', 'description'];
    public $timestamps = true;

    public function product()
    {
        return $this->hasMany('App\Product');
    }
}
