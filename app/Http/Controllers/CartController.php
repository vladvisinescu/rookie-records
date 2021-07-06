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
                'image' => $item->model->images['micro'],
                'url' => route('shop.vinyl.show', ['slug' => $item->model->slug])
            ];
        });
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->input('id'));

        Cart::instance('shopping')->add($product);

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    public function removeFromCart($id)
    {
        $product = Cart::instance('shopping')->get($id)->model;

        Cart::instance('shopping')->remove($id);

        return [
            'success' => true,
            'product' => $product
        ];
    }
}
