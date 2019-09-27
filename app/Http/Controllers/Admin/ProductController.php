<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Discount;
use Illuminate\Http\Request;
use App\Product;
use Mews\Purifier\Facades\Purifier;


class ProductController extends Controller
{
    public function index(){
        $products = Product::orderBy('updated_at', 'desc')->paginate(9);
        $discount = Discount::orderBy('updated_at', 'desc')->first();

       return view('admin.product.index', ['products'=>$products, 'discount'=>$discount]);
    }

    public function add(){

        return view('admin.product.add');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.edit', ['product' => $product]);
    }

    public function store($id = null, Request $request, Product $product)
    {
        $request->merge([
            'name' => Purifier::clean($request->name),
            'description' => Purifier::clean($request->description),
            'sku' => Purifier::clean($request->sku),
            'price' => Purifier::clean($request->price),
            'discount' => Purifier::clean($request->discount),
        ]);
        $validated = $request->validate([
            'name' => 'string|required|max:255',
            'description' => 'string|required',
            'sku' => 'string|required',
            'price' => 'numeric|required',
            'discount' => 'numeric|required',
            'picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->picture){
            $pictureName = time().'.'.$request->picture->extension();
            $request->picture->move(public_path('images'), $pictureName);
            $validated['picture'] = 'images/' . $pictureName;
        }

        if ($validated) {
            try {
                $product->updateOrCreate(['id' => $id], $validated);
                return redirect()->to(route('admin.product.index'));
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors([ $e->getMessage()])->withInput();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([ $e->getMessage()])->withInput();
            }
        }
        return redirect()->back()->withInput();
    }

    public function delete(Request $request)
    {
        $products = collect($request->input('selected', []));
        if ($products->isNotEmpty()) {
            Product::destroy($products);
        }
        return redirect()->to(route('admin.product.index'));
    }



}
