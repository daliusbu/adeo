<?php

namespace App\Http\Controllers;

use App\Review;
use App\Services\DiscountService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('product')->orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.review.index', compact('reviews'));
    }

    public function add($productId, ProductService $productService)
    {
        $product = $productService->getProduct($productId);
        $reviews = Review::where('product_id', $productId)->orderBy('created_at', 'desc')->paginate(3);
        $discount = DiscountService::getDiscount();

        if ($discount->tax > 0 && $discount->tax_active > 0) {
            $product->price = round($product->price * (1 + $discount->tax / 100), 2);
        }

        return view('review.add', compact('product', 'reviews', 'discount'));
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return view('admin.review.edit', ['review' => $review]);
    }

    public function store(Review $review, Request $request )
    {
//        dd($review);
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
                $review->update($validated);
                return redirect()->to(route('admin.review.index'));
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors([$e->getMessage()])->withInput();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([$e->getMessage()])->withInput();
            }
        }
        return redirect()->back()->withInput();
    }

    public function delete(Request $request)
    {
        $reviews = collect($request->input('selected', []));
        if ($reviews->isNotEmpty()) {
            Review::destroy($reviews);
        }
        return redirect()->back();
    }

}
