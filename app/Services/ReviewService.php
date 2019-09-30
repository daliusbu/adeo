<?php

namespace App\Services;

use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class ReviewService
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function validate(Request $request)
    {
        $request->merge([
            'product_id' => Purifier::clean($request->product_id),
            'stars' => Purifier::clean($request->rating),
            'comment' => Purifier::clean($request->comment),
            'title' => Purifier::clean($request->title),
            'username' => Purifier::clean($request->username),
        ]);
        $validated = $request->validate([
            'product_id' => 'numeric|required',
            'stars' => 'numeric|max:5|min:0',
            'comment' => 'string|required',
            'title' => 'string|required',
            'username' => 'string|required',
        ]);

        return $validated;
    }
}
