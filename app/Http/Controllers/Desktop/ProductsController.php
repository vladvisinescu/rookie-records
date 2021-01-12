<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Records\CreateProductRequest;
use App\Models\Product;

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

    public function saveProduct(CreateProductRequest $request)
    {
        return $request->all();

        $product = new Product;
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->country = $request->input('country');
        $product->grading = $request->input('grading');
        $product->grading = $request->input('grading');

    }
}
