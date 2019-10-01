<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App
 */
class Product extends Model
{
    public $avgRating;
    public $countRating;
    protected $fillable = [
        'sku',
        'name',
        'description',
        'picture',
        'price',
        'discount',
        'picture',
        'status',
    ];

    public function review(){
        return $this->hasMany('App\Review');
    }
}
