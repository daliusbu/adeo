<?php

namespace App\Services;

use App\Discount;

class DiscountService
{
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
}
