<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Product;

class ProductController extends Controller
{
    protected $g_discount = 0;
    protected $gd_active = 0;
    protected $gd_fixed = 0;
    protected $tax = 0;
    protected $tax_active = 0;

    public function index()
    {
        $products = Product::where('status', 1)->orderBy('updated_at', 'desc')->with('review')->paginate(9);
        $discount = Discount::orderBy('updated_at', 'desc')->first();

        if($discount){
            $this->tax = $discount->tax ? $discount->tax : 0;
            $this->tax_active = $discount->tax_active ? $discount->tax_active : 0;
            $this->g_discount = $discount->g_discount ? $discount->g_discount : 0;
            $this->gd_active = $discount->gd_active ? $discount->gd_active : 0;
            $this->gd_fixed = $discount->gd_fixed ? $discount->gd_fixed : 0;
        }
        $products->getCollection()->transform(function ($product) {
            $avgRating = $product->review->avg('stars');
            $countRating = $product->review->count('stars');
            $product->avgRating = $avgRating ? round($avgRating, 1) : 0;
            $product->countRating = $countRating ? $countRating : 0;

            if ($this->tax > 0 && $this->tax_active > 0) {
                $product->price = round($product->price * (1 + $this->tax / 100), 2);
            }
            return $product;
        });

        if ($this->gd_active > 0) {
            $products->getCollection()->transform(function ($product) {
                $product->discount = $this->g_discount;
                return $product;
            });
        }

        return view('product.index', ['products' => $products, 'discount' => $discount]);
    }
}
