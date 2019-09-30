<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Services\DiscountService;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * @param Discount $discount
     * @param DiscountService $service
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Discount $discount, DiscountService $service, Request $request)
    {
        $validated = $service->validate($request);

        if ($validated) {
            try {
                $discount->create($validated);
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
