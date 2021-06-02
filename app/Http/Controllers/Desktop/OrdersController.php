<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderDispatched;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{

    public function home()
    {
        return view('desktop.orders.home');
    }

    public function getAllOrders(Request $request)
    {
        return Order::orderBy('created_at', 'desc')->with(['user', 'address', 'products'])->get();
    }

    public function confirmOrder(Order $order, Request $request)
    {
        $order->confirmed_at = now();
        $order->save();

        Auth::user()->notify(new OrderDispatched($order));

        return response()->json([]);
    }
}
