<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDetails\Artist;
use App\Models\ProductDetails\Genre;
use App\Models\ProductTypes\Vinyl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class VinylController extends Controller
{
    public function index()
    {
        return view('shop.vinyl.index');
    }

    public function show($slug)
    {
        $product = Product::query()->where('slug', $slug)->with(['vinyls', 'vinyls.artists', 'vinyls.genres'])->first();

        return view('shop.vinyl.show', [
            'product' => $product
        ]);
    }

    public function getVinyls(Request $request)
    {

        $products = Product::query()->published()->with(['vinyls', 'vinyls.genres', 'vinyls.artists']);

        if ($request->input('term')) {
            $products = $products->where('title', 'LIKE', '%'.$request->input('term').'%');
        }

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
            $products = $products->whereBetween('price', $request->input('range'));
        }

        $products = $products->orderBy('created_at', 'desc');

        if ($request->has('exportResults')) {
            $date = now()->format('d F Y H:i:s');
            $random = Str::random(6);
            $fileName = Str::slug("Rookie Records Products Export $date $random") . '.xlsx';

            Excel::store(new ProductsExport($products), $fileName, 'product_exports');

            return '/exports/products/' . $fileName;
        }

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
            'artists' => Cache::rememberForever('vinyl.artists', function () {
                return Artist::orderBy('name', 'ASC')->get();
            }),
            'genres' => Cache::rememberForever('vinyl.genres', function () {
                return Genre::orderBy('name', 'ASC')->get();
            }),
            'years' => Cache::rememberForever('vinyl.years', function () {
                return  Vinyl::distinct('year')->get(['year'])->pluck('year')->sort()->values()->all();
            }),
            'countries' => Cache::rememberForever('vinyl.countries', function () {
                return Vinyl::distinct('country')->get(['country'])->pluck('country')->sort()->values()->all();
            }),
            'categories' => Cache::rememberForever('vinyl.categories', function () {
                return ProductCategory::orderBy('name', 'ASC')->get(['id', 'name']);
            }),
            'range' => Cache::rememberForever('vinyl.price.range', function () {
                return [
                    floor(DB::table('products')->select(DB::raw('MIN(CAST(price AS DECIMAL(8,2))) as value'))->first('value')->value),
                    ceil(DB::table('products')->select(DB::raw('MAX(CAST(price AS DECIMAL(8,2))) as value'))->first('value')->value),
                ];
            })
        ];
    }
}
