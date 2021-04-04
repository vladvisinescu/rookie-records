<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getCartSession()
    {
        return Cart::instance('shopping')->content()->map(function ($item) {
            return [
                'id' => $item->model->uuid,
                'title' => $item->model->title,
                'price' => $item->model->price,
                'quantity' => $item->qty,
                'image' => $item->model->vinyls()->first()->images[0]->resource_url,
                'url' => route('shop.vinyl.show', ['slug' => $item->model->slug])
            ];
        });
    }

    public function addToCart(Request $request)
    {
        Cart::instance('shopping')->add(Product::find($request->input('id')));

        return response()->json([
            'success' => true
        ]);
    }

    public function removeFromCart($id)
    {
        Cart::instance('shopping')->remove($id);

        return true;
    }
}
