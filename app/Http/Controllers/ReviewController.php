<?php

namespace App\Http\Controllers;

use App\Review;
use App\Services\DiscountService;
use App\Services\ProductService;
use App\Services\ReviewService;
use Illuminate\Http\Request;

/**
 * Class ReviewController
 * @package App\Http\Controllers
 */
class ReviewController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $reviews = Review::with('product')->orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.review.index', compact('reviews'));
    }

    /**
     * @param $productId
     * @param ProductService $productService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return view('admin.review.edit', ['review' => $review]);
    }

    /**
     * @param null $id
     * @param Request $request
     * @param ReviewService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($id = null, Request $request, ReviewService $service)
    {
        $review = new Review();
        $validated = $service->validate($request);

        if ($validated) {
            try {
                $review->updateOrCreate(compact('id'), $validated);
                return redirect()->to(route('review.add', ['product' => $validated['product_id']]));
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors([$e->getMessage()])->withInput();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([$e->getMessage()])->withInput();
            }
        }
        return redirect()->back()->withInput();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $reviews = collect($request->input('selected', []));
        if ($reviews->isNotEmpty()) {
            Review::destroy($reviews);
        }
        return redirect()->back();
    }
}
