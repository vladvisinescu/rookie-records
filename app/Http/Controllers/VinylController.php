<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDetails\Artist;
use App\Models\ProductDetails\Genre;
use App\Models\ProductTypes\Vinyl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VinylController extends Controller
{
    public function index()
    {
        return view('shop.vinyl.index');
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with(['vinyls', 'vinyls.artists', 'vinyls.genres'])->first();

        return view('shop.vinyl.show', [
            'product' => $product
        ]);
    }

    public function getVinyls(Request $request)
    {

        $products = Product::query()->with(['vinyls', 'vinyls.genres', 'vinyls.artists']);

        if ($request->has('categories')) {
            $products = $products->whereIn('category_id', $request->input('categories'));
        }

        if($request->has('genres')) {
            $products = $products->whereHas(
                'vinyls.genres', function ($query) use ($request) {
                    $query->whereIn('genres.id', $request->input('genres') ?? []);
                },
            );
        }

        if($request->has('artists')) {
            $products = $products->whereHas(
                'vinyls.artists', function ($query) use ($request) {
                    $query->whereIn('artists.id', $request->input('artists') ?? []);
                },
            );
        }

        if($request->has('country')) {
            $products = $products->whereHas(
                'vinyls.artists', function ($query) use ($request) {
                    $query->whereIn('artists.id', $request->input('artists') ?? []);
                },
            );
        }

        if($request->has('years')) {
            $products = $products->whereHas(
                'vinyls', function ($query) use ($request) {
                    $query->whereIn('year', $request->input('years') ?? []);
                },
            );
        }

        if($request->has('countries')) {
            $products = $products->whereHas(
                'vinyls', function ($query) use ($request) {
                    $query->whereIn('country', $request->input('countries') ?? []);
                },
            );
        }

        if ($request->input('range')) {
            $products = $products
                ->whereBetween('price', $request->input('range'));
        }

        if ($request->input('term')) {
            $constraints = $products;
            $products = Product::search($request->input('term'))->constrain($constraints);
        }

        $products = $products->orderBy('created_at', 'desc');

        if ($request->has('limit')) {
            $products = $products->limit($request->input('limit'))->get();
        } else {
            $products = $products->paginate(24);
        }

        return $products;
    }

    public function getFilterData(Request $request)
    {
        return [
            'artists' => Artist::orderBy('name', 'ASC')->get(),
            'genres' => Genre::orderBy('name', 'ASC')->get(),
            'years' => Vinyl::distinct('year')->get(['year'])->pluck('year')->sort()->values()->all(),
            'countries' => Vinyl::distinct('country')->get(['country'])->pluck('country')->sort()->values()->all(),
            'categories' => ProductCategory::orderBy('name', 'ASC')->get(['id', 'name']),
            'range' => [
                floor(DB::table('products')->select(DB::raw('MIN(CAST(price AS DECIMAL(8,2))) as value'))->first('value')->value),
                ceil(DB::table('products')->select(DB::raw('MAX(CAST(price AS DECIMAL(8,2))) as value'))->first('value')->value),
            ]
        ];
    }
}
