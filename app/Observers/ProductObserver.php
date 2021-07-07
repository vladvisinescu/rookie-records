<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProductObserver
{
    public function __construct()
    {
        Cache::forget('vinyl.years');
        Cache::forget('vinyl.countries');
        Cache::forget('vinyl.price.range');
    }

    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function saving(Product $product)
    {
        $product->uuid = Str::uuid();
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
