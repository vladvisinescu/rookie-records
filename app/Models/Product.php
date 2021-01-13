<?php

namespace App\Models;

use App\Models\ProductTypes\Vinyl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Ramsey\Uuid\UuidInterface;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property mixed title
 * @property mixed grading
 * @property mixed country
 * @property mixed getInCartAttribute
 * @property mixed description
 * @property mixed|string product_type
 * @property mixed price
 * @property mixed|UuidInterface uuid
 *
 * @method  mixed description
 */
class Product extends Model
{
    use HasSlug;
    use HasFactory;
    use Searchable;

    protected $appends = [
        'in_cart'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function vinyls()
    {
        return $this->hasMany(Vinyl::class, 'product_id', 'id');
    }

    public function getInCartAttribute()
    {
        return collect(session()->get('cart'))->only('id')->has($this->getKey());
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array->artists = $this->vinyl->first()->artists->map(fn($artist) => $artist->name);

        return $array;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }
}
