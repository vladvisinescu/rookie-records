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

class CheckoutController extends Controller
{

    public function index(Request $request)
    {
        if (Cart::instance('shopping')->content()->isEmpty()) {
            return redirect()->route('home');
        }

        return view('shop.checkout.index');
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
            $total = Cart::instance('shopping')->priceTotal();

            // delivery fee?
            if ($total < 30) {
                $total += 5;
            }

            $user = auth()->user();

            /** @var User $user **/
            $customer = $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($request->input('payment.id'));

            $payment = $user->charge(
                $total * 100,
                $request->input('payment.id')
            );

            $payment = $payment->asStripePaymentIntent();

            $order = $user->orders()->create([
                'transaction_id' => Str::uuid(),
                'stripe_id' => $request->input('payment.id'),
                'total' => $payment->charges->data[0]->amount / 100,
                'payed_at' => now(),
                'address_id' => $request->input('address_id')
            ]);

            foreach (Cart::content() as $product) {
                $product->model->update([ 'sold_at' => now() ]);

                $order->products()->attach($product->model->id, [
                    'quantity' => $product->qty
                ]);
            }

            // comment for testing
//            Cart::destroy();

            $order->load(['products', 'user', 'address']);

            Auth::user()->notify(new OrderConfirmed($order));

            return new OrderResource($order);

        } catch (IncompletePayment $exception) {
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('home')]
            );
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 402);
        }
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
