<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
      'tax',
      'tax_active',
      'g_discount',
      'gd_active',
      'gd_fixed',
    ];

}
