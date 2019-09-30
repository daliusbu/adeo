<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Product;
use App\Review;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class ReviewController extends Controller
{
    protected $g_discount = 0;
    protected $gd_active = 0;
    protected $gd_fixed = 0;
    protected $tax = 0;
    protected $tax_active = 0;

    public function add($productId)
    {
        $product = Product::find($productId);
        $product->countRating = Review::where('product_id', $productId)->count('id');
        $product->avgRating = Review::where('product_id', $productId)->avg('stars');
        $reviews = Review::where('product_id', $productId)->orderBy('created_at', 'desc')->paginate(3);

        $discount = Discount::orderBy('updated_at', 'desc')->first();

        if($discount){
            $this->tax = $discount->tax ? $discount->tax : 0;
            $this->tax_active = $discount->tax_active ? $discount->tax_active : 0;
            $this->g_discount = $discount->g_discount ? $discount->g_discount : 0;
            $this->gd_active = $discount->gd_active ? $discount->gd_active : 0;
            $this->gd_fixed = $discount->gd_fixed ? $discount->gd_fixed : 0;
        }

        if ($this->tax > 0 && $this->tax_active > 0) {
            $product->price = round($product->price * (1 + $this->tax / 100), 2);
        }

        return view('review.add', compact('product', 'reviews', 'discount'));
    }

    public function store($id = null, Request $request, Review $review)
    {
        $request->merge([
            'product_id' => Purifier::clean($request->product_id),
            'stars' => Purifier::clean($request->rating),
            'comment' => Purifier::clean($request->comment),
            'title' => Purifier::clean($request->title),
            'username' => Purifier::clean($request->username),
        ]);
        $validated = $request->validate([
            'product_id' => 'numeric|required',
            'stars' => 'numeric|max:5|min:0',
            'comment' => 'string|required',
            'title' => 'string|required',
            'username' => 'string|required',
        ]);
        if ($validated) {
            try {
                $review->Create($validated);
                return redirect()->to(route('review.add', ['product' => $request->product_id]));
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors([$e->getMessage()])->withInput();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([$e->getMessage()])->withInput();
            }
        }
        return redirect()->back()->withInput();
    }

}
