<?php

namespace App\Http\Controllers;

use App\Product;
use App\Review;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class ReviewController extends Controller
{
    public function index()
    {

    }

    public function add($productId)
    {
        $reviews = Review::where('product_id', $productId)->orderBy('created_at', 'desc')->paginate(3);
        $product = Product::find($productId);
        $count = $sum = $ratingsCount = $avgStars = 0;
        foreach ($reviews as $review) {
            $count++;
            $sum += $review->stars;
        }
        if ($count > 0){
            $avgStars = round($sum / $count, 1);
            $ratingsCount = Review::where('product_id', $productId)->count();
        }

        return view('review.add', compact('product', 'avgStars', 'ratingsCount', 'reviews'));
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
