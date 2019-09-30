<?php

namespace App\Services;

use App\Discount;
use App\Product;
use App\Review;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class ProductService
{
    /**
     * @var Discount
     */
    protected $discount;

    /**
     * @param $id
     * @return Product
     */
    public function getProduct($id)
    {
        $product = Product::find($id);
        $product->countRating = Review::where('product_id', $id)->count('id');
        $product->avgRating = Review::where('product_id', $id)->avg('stars');

        return $product;
    }

    /**
     * @param int $active
     * @return Product[]
     */
    public function getProducts($active = 1)
    {
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

    /**
     * @param Request $request
     * @return array
     */
    public function validate(Request $request)
    {
        $request->merge([
            'name' => Purifier::clean($request->name),
            'description' => Purifier::clean($request->description),
            'sku' => Purifier::clean($request->sku),
            'price' => Purifier::clean($request->price),
            'discount' => Purifier::clean($request->discount),
            'status' => Purifier::clean($request->status),
        ]);
        $validated = $request->validate([
            'name' => 'string|required|max:255',
            'description' => 'string|required',
            'sku' => 'string|required',
            'price' => 'numeric|required',
            'discount' => 'numeric|required',
            'status' => 'numeric|required',
            'picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        return $validated;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function saveImage(Request $request)
    {
        $pictureName = time() . '.' . $request->picture->extension();
        $request->picture->move(public_path('images'), $pictureName);
        return $pictureName;
    }
}
