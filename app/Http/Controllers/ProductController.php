<?php

namespace App\Http\Controllers;

use App\Services\DiscountService;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $discount;

    /**
     * @param ProductService $productService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ProductService $productService)
    {
        $discount = DiscountService::getDiscount();
        $products = $productService->getProducts(1);

        return view('product.index', ['products' => $products, 'discount' => $discount]);
    }
}
