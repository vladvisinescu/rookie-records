<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        $results = Product::search($request->input('term'))->get()->take(10)->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'slug' => $item->slug,
                'artists' => $item->vinyls->first()->artists->pluck('name')->toArray(),
            ];
        });

        return $results;
    }
}
