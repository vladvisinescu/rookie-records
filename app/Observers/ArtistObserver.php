<?php

namespace App\Observers;

use App\Models\ProductDetails\Artist;
use Illuminate\Support\Facades\Cache;

class ArtistObserver
{

    public function __construct()
    {
        Cache::forget('vinyl.artists');
    }

    /**
     * Handle the Artist "created" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function saving(Artist $artist)
    {
        //
    }

    /**
     * Handle the Artist "updated" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function updated(Artist $artist)
    {
        //
    }

    /**
     * Handle the Artist "deleted" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function deleted(Artist $artist)
    {
        //
    }

    /**
     * Handle the Artist "restored" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function restored(Artist $artist)
    {
        //
    }

    /**
     * Handle the Artist "force deleted" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function forceDeleted(Artist $artist)
    {
        //
    }
}
