<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'description',
        'picture',
        'price',
        'discount',
        'picture',
    ];

    public function review(){
        return $this->hasMany('App\Review');
    }

}
