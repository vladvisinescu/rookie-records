<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class WikipediaService
{
    protected PendingRequest $http;
    protected string $releaseID;
    protected array $release;
    protected Collection $results;

    public function __construct()
    {
        $this->http = Http::withHeaders([
            'Authorization' => 'Discogs key=' . config('services.discogs.key') . ', secret=' . config('services.discogs.secret'),
            'Content-Type' => 'application/json'
        ])->baseUrl(config('services.discogs.base_url'));
    }

    public function getPageDescription(string $search)
    {
        $this->releaseID = $search;

        $url = '/releases/' . $this->releaseID;

        $result = $this->http->get($url);

        return $result->json();
    }

    public function search(string $term, array $types = [], array $filters = [])
    {
        $result = [];

        foreach ($types as $type) {
            $result[$type] = $this->http->get('/database/search', array_merge([
                'q' => trim($term),
                'type' => $type
            ], $filters))->json();
        }

        $this->results = collect($result);

        return $this;
    }

    public function getSearch(string $type)
    {
        if($this->results) {
            return $this->results[$type]['results'];
        }

        return null;
    }
}
