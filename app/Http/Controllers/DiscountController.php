<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Product;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class DiscountController extends Controller
{
    public function store($id = null, Request $request, Discount $discount)
    {

        $request->merge([
            'tax' => Purifier::clean($request->tax),
            'tax_active' => Purifier::clean($request->tax_active),
            'g_discount' => Purifier::clean($request->g_discount),
            'gd_active' => Purifier::clean($request->gd_active),
        ]);
        $validated = $request->validate([
            'tax' => 'numeric|max:50|nullable',
            'tax_active' => 'string',
            'g_discount' => 'numeric|max:100',
            'gd_active' => 'string',
        ]);

        $validated['tax'] = $validated['tax'] === "" ? null : $validated['tax'];
        $validated['g_discount'] = $validated['g_discount'] === "" ? null : $validated['g_discount'];

        if ($validated) {
            try {

                $discount->updateOrCreate(['id' => $id], $validated);
                return redirect()->to(route('product.index'));
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors([$e->getMessage()])->withInput();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([$e->getMessage()])->withInput();
            }
        }
        return redirect()->back()->withInput();
    }
}
