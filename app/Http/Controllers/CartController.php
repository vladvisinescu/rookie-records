<?php

namespace App\Http\Controllers;

use App\Models\Product;
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

        return Product::whereIn('id', $ids)->get()->map(function ($product) use ($request) {

            $quantity = array_filter(
                $request->session()->get('cart'),
                function ($item) use ($product) {
                    return $item['id'] == $product->id;
                }
            )[0]['quantity'];

//            dd($quantity);

            return [
                'id' => $product->uuid,
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->vinyls()->first()->images[0]->resource_url,
                'url' => route('shop.vinyl.show', ['slug' => $product->slug])
            ];
        });
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
