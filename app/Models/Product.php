<?php

namespace App\Models;

use App\Models\ProductDetails\Genre;
use App\Models\ProductTypes\Vinyl;
use Gloudemans\Shoppingcart\CanBeBought;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Ramsey\Uuid\UuidInterface;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property mixed id
 * @property mixed title
 * @property mixed grading
 * @property mixed country
 * @property mixed getInCartAttribute
 * @property mixed description
 * @property mixed|string product_type
 * @property mixed price
 * @property mixed|UuidInterface uuid
 * @property mixed created_at
 * @property \Illuminate\Support\Carbon|mixed published_at
 *
 * @method  mixed description
 */
class Product extends Model implements Buyable, HasMedia
{
    use HasSlug;
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $appends = [
        'published', 'date_created_human', 'date_created_diff', 'category_name'
    ];

    protected $fillable = [
        'sold_at'
    ];

    protected $casts = [
        'price' => 'float'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function vinyls()
    {
        return $this->hasMany(Vinyl::class, 'product_id', 'id');
    }

    public function categories()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product',  'order_id', 'product_id');
    }

    public function getRelated($count = 8)
    {
        $products = self::query()->with(['vinyls', 'vinyls.genres', 'vinyls.artists']);

        $genres = $this->vinyls()->first()->genres()->get()->map(function ($genre) {
            return $genre->id;
        })->all();

        $products = $products->whereHas(
            'vinyls.genres', function ($query) use ($genres) {
                $query->whereIn('genres.id', $genres);
            },
        )->inRandomOrder()->take($count);

        return $products->get();
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'artists' => $this->vinyls()->first()->artists->pluck('name')->toArray()
        ];
    }

    public function searchableAs()
    {
        return 'vinyl_records';
    }

    public function getCategoryNameAttribute()
    {
        return $this->categories->first()->name;
    }

    public function getPublishedAttribute()
    {
        return ($this->published_at != null);
    }

    public function getDateCreatedHumanAttribute(): string
    {
        return $this->created_at->format('d F Y');
    }

    public function getDateCreatedDiffAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }


    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    public function getBuyableDescription($options = null)
    {
        return $this->title;
    }

    public function getBuyablePrice($options = null)
    {
        return $this->price;
    }

    public function getBuyableWeight($options = null)
    {
        return 1;
    }
}
