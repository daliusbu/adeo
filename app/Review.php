<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'comment',
        'stars',
        'product_id',
        'title',
        'username',
    ];

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
