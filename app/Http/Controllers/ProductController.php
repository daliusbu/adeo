<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Product;
use App\Services\DiscountService;
use App\Services\ProductService;

class ProductController extends Controller
{
//    protected $tax = 0;

    protected $discount;

    public function index(ProductService $productService)
    {
        $discount = DiscountService::getDiscount();
        $products = $productService->getProducts(1);

        return view('product.index', ['products' => $products, 'discount' => $discount]);
    }
}
