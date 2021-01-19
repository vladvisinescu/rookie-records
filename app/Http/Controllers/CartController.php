<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{

    public $item = [
        [
            'id',
            'price',
            'quantity',
        ]
    ];

    public function getCartSession(Request $request)
    {
        $ids = collect($request->session()->get('cart'))->pluck('id');

        return $ids;
    }

    public function addToCart(Request $request)
    {
        $request->session()->push('cart', [
            'id' => $request->input('id'),
            'price' => $request->input('price'),
            'quantity' => 1,
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}
