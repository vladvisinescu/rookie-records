<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Records\CreateProductRequest;
use App\Models\Product;
use App\Models\ProductTypes\Vinyl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public function getAllProducts(Request $request)
    {
        $products = Product::search($request->input('term'))->get()->sortByDesc('created_at');

        return $products->load([
            'vinyls', 'vinyls.artists', 'vinyls.genres'
        ]);
    }

    public function saveProduct(CreateProductRequest $request)
    {

        $vinyl = new Vinyl;
        $vinyl->discogs_id = $request->input('discogs_id');
        $vinyl->title = $request->input('title');
        $vinyl->year = $request->input('year');
        $vinyl->country = $request->input('country');
        $vinyl->grading = $request->input('grading');
        $vinyl->description = $request->input('description');
        $vinyl->discogs_image_url = $request->input('discogs_image_url');
        $vinyl->type = $request->input('type');
        $vinyl->size = $request->input('size');
        $vinyl->tracklist = json_encode($request->input('tracklist'));
        $vinyl->images = json_encode($request->input('images'));
        $vinyl->save();

        $vinyl->artists()->attach($request->input('artists'));
        $vinyl->genres()->attach($request->input('genres'));

        $product = new Product;
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->product_type = 'vinyl';
        $product->price = $request->input('price');
        $product->uuid = Str::uuid();

        if ($request->boolean('published')) {
            $product->published_at = now();
        }

        $product->user()->associate(Auth::user());
        $product->categories()->associate($request->input('category_id'));

        collect($request->input('images'))->each(function ($image) use ($product) {
            $product->addMediaFromUrl($image['resource_url'])->toMediaCollection('vinyls', 'products');
        });

        $product->save();

        $vinyl->product()->associate($product);
        $vinyl->save();

        $product->searchable();
        $product->refresh();

        return $product->load(['vinyls', 'vinyls.artists', 'vinyls.genres', 'media']);
    }

    public function deleteProduct($product)
    {
        Product::find($product)->delete();

        return true;
    }
}
