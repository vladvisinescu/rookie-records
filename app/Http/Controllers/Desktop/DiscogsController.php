<?php

namespace App\Http\Controllers\Desktop;

use App\Models\ProductDetails\Genre;
use App\Services\DiscogsService;
use App\Models\ProductDetails\Artist;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscogsSearchRequest;

use Illuminate\Support\Str;

class DiscogsController extends Controller
{

    public function search(DiscogsSearchRequest $request)
    {
        $result = (new DiscogsService)
            ->search($request->input('term'), ['release'])
            ->getSearch('release');

        return $result;
    }

    public function getRecord($releaseID)
    {
        $result = (new DiscogsService)->getRelease($releaseID);

        $artists = collect($result['artists'])->map(function ($item) {
            return (new Artist)->findByNameOrCreate($item['name'], [
                'name' => $item['name'],
                'discogs_id' => $item['id'],
            ]);
        });

        $genres = collect($result['genres'])->map(function ($item) {
            return (new Genre)->findByNameOrCreate($item, [
                'name' => $item,
            ]);
        });

        return [
            'record' => [
                'title' => $result['title'],
                'discogs_price' => $result['lowest_price'],
                'country' => $result['country'],
                'grading' => '',
                'year' => $result['year'],
                'discogs_id' => $result['id'],
                'artists' => $artists,
                'genres' => $genres,
                'labels' => $result['labels'],
                'discogs_image_url' => $result['thumb'],
                'images' => $result['images'],
                'format' => $result['formats'][0],
                'tracklist' => $result['tracklist']
            ]
        ];
    }
}
