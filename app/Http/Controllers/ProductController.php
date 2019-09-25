<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Mews\Purifier\Facades\Purifier;


class ProductController extends Controller
{
    public function index(){
        $products = Product::paginate();

       return view('product.index', ['products'=>$products]);
    }

    public function add(){

        return view('product.add');
    }

    public function store($id = null, Request $request, Product $product)
    {
        $request->merge([
            'name' => Purifier::clean($request->name),
            'description' => Purifier::clean($request->description),
            'sku' => Purifier::clean($request->sku),
            'price' => Purifier::clean($request->price),
        ]);
        $validated = $request->validate([
            'name' => 'string|required|max:255',
            'description' => 'string|required',
            'sku' => 'string|required',
            'price' => 'numeric|required',
        ]);
        if ($validated) {
            try {
                $product->updateOrCreate(['id' => $id], $validated);
                return redirect()->to(route('product.index'));
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors([ $e->getMessage()])->withInput();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([ $e->getMessage()])->withInput();
            }
        }
        return redirect()->back()->withInput();
    }

}
