<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class DiscogsService
{
    protected $http;
    protected string $releaseID;
    protected array $release;
    protected Collection $results;

    public function __construct()
    {
        $this->http = Http::withHeaders([
            'Authorization' => 'Discogs key=' . env('DISCOGS_KEY') . ', secret=' . env('DISCOGS_SECRET'),
            'Content-Type' => 'application/json'
        ])->baseUrl(env('DISCOGS_BASE_URL'));
    }

    /**
     * Get release metadata by Discogs ID.
     * @param string $releaseID Discogs release ID
     * @return $this
     */
    public function getRelease(string $releaseID)
    {
        $this->releaseID = $releaseID;

        $url = '/releases/' . $this->releaseID;

        $result = $this->http->get($url);

        return $result->json();
    }

    /**
     * Search by term and options
     * @param string $term
     * @param array $types
     * @param array $filters
     * @return DiscogsService
     */
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

    /**
     * Return search results.
     * @param string $type
     * @return Collection|null
     */
    public function getSearch(string $type)
    {
        if($this->results) {
            return $this->results[$type]['results'];
        }

        return null;
    }
}
