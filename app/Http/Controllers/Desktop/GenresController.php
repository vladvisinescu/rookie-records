<?php

namespace App\Http\Controllers\Desktop;

use App\Models\ProductDetails\Genre;

use App\Http\Controllers\Controller;
use App\Http\Requests\Records\CreateGenreRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenresController extends Controller
{
    public function getAllGenres(Request $request)
    {
        $genres = Genre::query();

        if($request->input('term')) {
            $genres = $genres->where('name', 'LIKE', '%'. $request->input('term') .'%');
        }

        $genres = $genres->orderBy('name')->get();

        return $genres->groupBy(function ($genre, $key) {
            return strtoupper($genre->name[0]);
        })->sortBy(function ($item, $key) {
            return $key;
        });
    }

    public function createGenre(CreateGenreRequest $request)
    {
        return Genre::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')) . '-' . Str::random(8),
        ]);
    }
}
