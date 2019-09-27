<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){

        $products = Product::orderBy('updated_at', 'desc')->paginate();
        $discount = Discount::orderBy('updated_at', 'desc')->first();
        return view('product.index', ['products'=>$products, 'discount' => $discount]);
    }
}
