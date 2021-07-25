<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Notifications\OrderConfirmed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Log;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

use App\Http\Resources\OrderResource;
use App\Http\Requests\Orders\SubmitOrderRequest;
use Stripe\BaseStripeClient;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\StripeClient;

class CheckoutController extends Controller
{

    public function index(Request $request)
    {
        if (Cart::instance('shopping')->content()->isEmpty()) {
            return redirect()->route('home');
        }

        return view('shop.checkout.index');
    }

    public function getClientStripeSecret(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $amount = Cart::instance('shopping')->priceTotal();

        if ($amount < 30) {
            $amount += 5;
        }

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount * 100,
            'currency' => 'gbp',
        ]);

        return response()->json(['paymentIntent' => $paymentIntent]);
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
        $total = Cart::instance('shopping')->priceTotal();

        if ($total < 30) {
            $total += 5;
        }

        $payment = $request->input('payment');
        $user = auth()->user();

        $stripe = new StripeClient(config('services.stripe.secret'));
        $intent = $stripe->paymentIntents->retrieve($payment['id']);

        if ($intent['status'] === 'succeeded') {
            $order = $user->orders()->create([
                'transaction_id' => Str::uuid(),
                'stripe_id' => $intent['id'],
                'total' => $total,
                'payed_at' => now(),
                'address_id' => $request->input('address_id'),
            ]);

            foreach (Cart::instance('shopping')->content() as $product) {
                $order->products()->attach($product->model->id, ['quantity' => $product->qty]);
                $product->model->sold_at = now();
                $product->model->save();
            }

            Auth::user()->notify(new OrderConfirmed($order));

            Cart::instance('shopping')->destroy();

            $order->load(['products', 'user', 'address']);

            return new OrderResource($order);
        }

        return response()->json([
            'success' => false,
            'message' => 'Looks like something went wrong. Call us maybe?'
        ], 400);
    }

    public function orderDetails($orderID)
    {
        $order = Order::findByUUID($orderID);

        if (!$order) {
            abort(404);
        }

        return view('shop.checkout.order-details', [
            'order' => $order
        ]);
    }
}
