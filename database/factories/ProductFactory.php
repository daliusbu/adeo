<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'sku'=>$faker->unique()->word,
        'name'=>$faker->sentence(3, true),
        'description'=>$faker->paragraph,
        'picture'=>$faker->imageUrl(300, 300, 'technics'),
        'price'=>$faker->numberBetween(200, 50000),
        'discount'=>$faker->numberBetween(0, 32),
        'status'=>$faker->numberBetween(0, 1),
    ];
});
