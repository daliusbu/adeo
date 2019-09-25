<?php

namespace App\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;
use App\Product;
use Mews\Purifier\Facades\Purifier;


class ProductController extends Controller
{
    public function index(){
        $products = Product::orderBy('updated_at', 'desc')->paginate();
        $discount = Discount::orderBy('updated_at', 'desc')->first();

       return view('product.index', ['products'=>$products, 'discount'=>$discount]);
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
            'picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $pictureName = time().'.'.$request->picture->extension();
        $request->picture->move(public_path('images'), $pictureName);
        $validated['picture'] = 'images/' . $pictureName;
//        dd( $validated['picture']);

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
