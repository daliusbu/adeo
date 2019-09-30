<?php

namespace App\Services;

use App\Discount;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class DiscountService
{
    /**
     * @return Discount
     */
    public static function getDiscount()
    {
        $discount = Discount::orderBy('updated_at', 'desc')->first();
        $discount = $discount ? $discount : new Discount();

        $discount->tax = $discount->tax ? $discount->tax : 0;
        $discount->tax_active = $discount->tax_active ? $discount->tax_active : 0;
        $discount->g_discount = $discount->g_discount ? $discount->g_discount : 0;
        $discount->gd_active = $discount->gd_active ? $discount->gd_active : 0;
        $discount->gd_fixed = $discount->gd_fixed ? $discount->gd_fixed : 0;

        return $discount;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function validate(Request $request)
    {
        $request->merge([
            'tax' => Purifier::clean($request->tax),
            'tax_active' => Purifier::clean($request->tax_active),
            'g_discount' => Purifier::clean($request->g_discount),
            'gd_active' => Purifier::clean($request->gd_active),
            'gd_fixed' => Purifier::clean($request->gd_fixed),
        ]);
        $validated = $request->validate([
            'tax' => 'numeric|max:50',
            'tax_active' => 'numeric',
            'g_discount' => 'numeric|max:100',
            'gd_active' => 'numeric',
            'gd_fixed' => 'numeric|max:1',
        ]);

        $validated['tax'] = $validated['tax'] === "" ? null : $validated['tax'];
        $validated['g_discount'] = $validated['g_discount'] === "" ? null : $validated['g_discount'];

        return $validated;
    }
}
