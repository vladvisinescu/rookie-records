<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetails\Artist;
use App\Models\ProductDetails\Genre;
use Illuminate\Http\Request;

class VinylController extends Controller
{
    public function index()
    {
        return view('shop.vinyl.index');
    }

    public function getVinyls(Request $request)
    {
        $products = Product::query();
//            ->with([
//            'vinyls', 'vinyls.artists', 'vinyls.genres'
//        ]);

        $products = $products->with(['vinyls', 'vinyls.genres' => function ($query) use ($request) {
            $query->whereIn('id', $request->input('genres') ?? []);
        }, 'vinyls.artists' => function ($query) use ($request) {
            $query->whereIn('id', $request->input('artists') ?? []);
        }]);

        if ($request->input('term')) {
            $constraints = $products;
            $products = Product::search($request->input('term'))->constrain($constraints);
        }

        $products = $products->orderBy('created_at', 'desc');

        return $products->get();
    }

    public function getFilterData(Request $request)
    {
        return [
            'artists' => Artist::orderBy('name', 'ASC')->get(),
            'genres' => Genre::orderBy('name', 'ASC')->get(),
        ];
    }
}
