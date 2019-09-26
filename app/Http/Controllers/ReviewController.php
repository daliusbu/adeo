<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(){

    }

    public function store(Request $request){

        dd($request->rating);
        return view('admin.product.add');
    }
}
