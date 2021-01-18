<?php

namespace App\Models;

use App\Models\ProductDetails\Genre;
use App\Models\ProductTypes\Vinyl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Ramsey\Uuid\UuidInterface;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

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
 *
 * @method  mixed description
 */
class Product extends Model
{
    use HasSlug;
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $appends = [
        'in_cart', 'date_created_human', 'date_created_diff'
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

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
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
}
