<?php

namespace App\Observers;

use App\Models\ProductDetails\Genre;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class GenreObserver
{

    public function __construct()
    {
        Cache::forget('vinyl.genres');
    }

    /**
     * Handle the Genre "created" event.
     *
     * @param Genre $genre
     * @return void
     */
    public function saving(Genre $genre)
    {
        //
    }

    /**
     * Handle the Genre "updated" event.
     *
     * @param Genre $genre
     * @return void
     */
    public function updated(Genre $genre)
    {
        //
    }

    /**
     * Handle the Genre "deleted" event.
     *
     * @param Genre $genre
     * @return void
     */
    public function deleted(Genre $genre)
    {
        //
    }

    /**
     * Handle the Genre "restored" event.
     *
     * @param Genre $genre
     * @return void
     */
    public function restored(Genre $genre)
    {
        //
    }

    /**
     * Handle the Genre "force deleted" event.
     *
     * @param Genre $genre
     * @return void
     */
    public function forceDeleted(Genre $genre)
    {
        //
    }
}
