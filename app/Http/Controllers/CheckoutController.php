<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\SubmitOrderRequest;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function index(Request $request)
    {
        $cart = Cart::instance('shopping')->content()->map(function ($item) {
            return [
                'id' => $item->model->uuid,
                'title' => $item->model->title,
                'price' => $item->model->price,
                'quantity' => $item->qty,
                'image' => $item->model->vinyls()->first()->images[0]->resource_url,
                'url' => route('shop.vinyl.show', ['slug' => $item->model->slug])
            ];
        });

        return view('shop.checkout.index', [
            'cart' => $cart
        ]);
    }

    public function getAllProducts(Request $request)
    {
        return Cart::instance('shopping')->content()->map(function ($item) {
            return [
                'id' => $item->model->uuid,
                'title' => $item->model->title,
                'price' => $item->model->price,
                'quantity' => $item->qty,
                'image' => $item->model->vinyls()->first()->images[0]->resource_url,
                'url' => route('shop.vinyl.show', ['slug' => $item->model->slug]),
                'model' => $item->model
            ];
        });
    }

    public function submitOrder(SubmitOrderRequest $request)
    {

        try {
            $total = intval(number_format(Cart::instance('shopping')->total(), 0));
            $user = auth()->user();

            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($request->input('payment.id'));

            $payment = $user->charge(
                $total * 100,
                $request->input('payment.id')
            );

            $payment = $payment->asStripePaymentIntent();

            $order = $user->orders()->create([
                'transaction_id' => $request->  input('payment.id'),
                'total' => $payment->charges->data[0]->amount / 100
            ]);

            foreach (Cart::content() as $product) {
                $order->products()->attach($product->model->id, ['quantity' => $product->qty]);
            }

            $order->load('products');

            return  $order;

        } catch (\Exception $e) {
            return $e;
        }


    }
}
