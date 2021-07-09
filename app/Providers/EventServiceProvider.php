<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDetails\Artist;
use App\Models\ProductDetails\Genre;
use App\Models\User;
use App\Observers\ArtistObserver;
use App\Observers\GenreObserver;
use App\Observers\ProductCategoryObserver;
use App\Observers\ProductObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);

        Product::observe(ProductObserver::class);
        ProductCategory::observe(ProductCategoryObserver::class);

        Artist::observe(ArtistObserver::class);
        Genre::observe(GenreObserver::class);
    }
}
