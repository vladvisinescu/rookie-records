<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;

class ProductsController extends Controller
{

    public function home()
    {
        return view('desktop.products.home');
    }

    public function create()
    {
        return view('desktop.products.create');
    }
}
