<?php

namespace App\Models;

use App\Models\ProductTypes\Vinyl;

use Laravel\Scout\Searchable;
use Ramsey\Uuid\UuidInterface;

use Gloudemans\Shoppingcart\Contracts\Buyable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
 * @property float price
 * @property float discogs_price
 * @property mixed|UuidInterface uuid
 * @property mixed created_at
 * @property Carbon|mixed published_at
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
        'published', 'date_created_human', 'date_created_diff', 'category_name', 'images'
    ];

    protected $fillable = ['sold_at', 'published_at'];

    protected $casts = ['price' => 'float'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(400);

        $this->addMediaConversion('micro')->width(100);
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

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeAvailableForPurchase($query)
    {
        return $query->whereNull('sold_at');
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
            'price' => $this->getBuyablePrice(),
            'category_id' => $this->categories()->first()->getKey(),
            'artists' => $this->vinyls()->first() ? $this->vinyls()->first()->artists->pluck('name')->toArray() : [],
            'genres' => $this->vinyls()->first() ? $this->vinyls()->first()->genres->pluck('name')->toArray() : []
        ];
    }

    public function searchableAs()
    {
        return app()->environment() . '_vinyl_records';
    }

    public function getImagesAttribute()
    {
        if (!$this->hasMedia('vinyls')) {
            return [
                'full' => asset('images/placeholder.jpg'),
                'thumb' => asset('images/placeholder.jpg'),
                'micro' => asset('images/placeholder.jpg'),
            ];
        }

        return [
            'full' => $this->getFirstMedia('vinyls')->getUrl(),
            'thumb' => $this->getFirstMedia('vinyls')->getUrl('thumb'),
            'micro' => $this->getFirstMedia('vinyls')->getUrl('micro')
        ];
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
