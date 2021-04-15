<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser()
    {
        return auth()->check() ? new UserResource(auth()->user()) : null;
    }

    public function getOrders(Request $request)
    {
        $orders = $request->user()->orders()->latest()->with('products')->get();

        return OrderResource::collection($orders);
    }
}
