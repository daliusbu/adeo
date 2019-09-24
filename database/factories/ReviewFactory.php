<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    $products = Product::all()->pluck('id')->toArray();
    return [
        'comment' => $faker->sentence,
        'stars' => $faker->numberBetween(1,5),
        'product_id' => $products[array_rand($products)],
    ];
});
