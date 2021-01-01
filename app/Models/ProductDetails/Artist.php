<?php

namespace App\Models\ProductDetails;

use App\Models\ProductTypes\Vinyl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Artist extends Model
{
    use HasSlug;
    use HasFactory;

    protected $table = 'artists';

    protected $fillable = ['name'];

    public function vinyls()
    {
        return $this->belongsToMany(Vinyl::class, 'vinyl_artist', 'artist_id', 'vinyl_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }
}
