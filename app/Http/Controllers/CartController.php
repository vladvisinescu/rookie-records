<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{

    public function getCart(Request $request)
    {
        return $request->all();
    }

    public function addToCart(Request $request)
    {
        return $request->all();
    }
}
