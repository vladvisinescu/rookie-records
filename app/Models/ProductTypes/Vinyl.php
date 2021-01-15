<?php

namespace App\Models\ProductTypes;

use App\Casts\Json;

use App\Models\Product;
use App\Models\ProductDetails\Label;
use App\Models\ProductDetails\Genre;
use App\Models\ProductDetails\Artist;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed discogs_id
 * @property mixed title
 * @property mixed year
 * @property mixed country
 * @property mixed grading
 * @property mixed description
 * @property mixed discogs_image_url
 * @property mixed images
 */
class Vinyl extends Model
{
    use HasFactory;

    protected $table = 'vinyls';

    public $appends = ['images'];

    public function getImagesAttribute()
    {
        return json_decode($this->attributes['images']);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'vinyl_genre', 'vinyl_id', 'genre_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'vinyl_label', 'vinyl_id', 'label_id');
    }

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'vinyl_artist', 'vinyl_id', 'artist_id');
    }
}
