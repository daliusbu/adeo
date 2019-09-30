<?php

namespace App\Services;

use App\Product;
use App\Review;

class ProductService
{
    protected $discount;

    public function getProduct($id)
    {
        $product = Product::find($id);
        $product->countRating = Review::where('product_id', $id)->count('id');
        $product->avgRating = Review::where('product_id', $id)->avg('stars');

        return $product;
    }

    public function getProducts($active = 1){

        $this->discount = DiscountService::getDiscount();
        $products = Product::where('status', $active)->orderBy('updated_at', 'desc')->with('review')->paginate(9);
        $products->getCollection()->transform(function ($product) {
            $avgRating = $product->review->avg('stars');
            $countRating = $product->review->count('stars');
            $product->avgRating = $avgRating ? round($avgRating, 1) : 0;
            $product->countRating = $countRating ? $countRating : 0;

            if ($this->discount->tax > 0 && $this->discount->tax_active > 0) {
                $product->price = round($product->price * (1 + $this->discount->tax / 100), 2);
            }
            return $product;
        });

        return $products;
    }
}
