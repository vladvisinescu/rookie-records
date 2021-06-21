<?php

namespace App\Http\Controllers\Desktop;

use App\Models\ProductDetails\Artist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Records\CreateArtistRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminated\Wikipedia\Wikipedia;
use PHPHtmlParser\Dom;

class ArtistsController extends Controller
{
    public function getAllArtists(Request $request)
    {
        $artists = Artist::query();

        if($request->input('term')) {
            $artists = $artists->where('name', 'LIKE', '%'. $request->input('term') .'%');
        }

        $artists = $artists->orderBy('name')->get();

        return $artists->groupBy(function ($artist, $key) {
            return strtoupper($artist->name[0]);
        })->sortBy(function ($item, $key) {
            return $key;
        });
    }

    public function createArtist(CreateArtistRequest $request)
    {
        $html = (new Dom)->loadStr((new Wikipedia)->preview($request->input('name')))->getElementsByClass('iwg-section')->innerHtml;
        $html = json_encode(explode('<br />', $html));

        return Artist::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')) . '-' . Str::random(8),
            'description' => $html
        ]);
    }
}
