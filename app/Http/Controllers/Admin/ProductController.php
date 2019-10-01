<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Discount;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::orderBy('updated_at', 'desc')->paginate(9);
        $discount = Discount::orderBy('updated_at', 'desc')->first();

        return view('admin.product.index', ['products' => $products, 'discount' => $discount]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {

        return view('admin.product.add');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.product.edit', ['product' => $product]);
    }

    /**
     * @param null $id
     * @param Request $request
     * @param Product $product
     * @param ProductService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($id = null, Request $request, Product $product, ProductService $service)
    {
        $validated = $service->validate($request);
        if (isset($validated['picture'])) {
            $validated['picture'] = $service->saveImage($request);
        }
        if ($validated) {
            try {
                $product->updateOrCreate(['id' => $id], $validated);
                return redirect()->to(route('admin.product.index'));
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
        $products = collect($request->input('selected', []));
        if ($products->isNotEmpty()) {
            Product::destroy($products);
        }

        return redirect()->to(route('admin.product.index'));
    }
}
