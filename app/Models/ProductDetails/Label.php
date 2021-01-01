<?php

namespace App\Models\ProductDetails;

use App\Models\ProductTypes\Vinyl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Label extends Model
{
    use HasSlug;
    use HasFactory;

    protected $table = 'labels';

    protected $fillable = ['name', 'discogs_id', 'api_url'];

    public function vinyls()
    {
        return $this->belongsToMany(Vinyl::class, 'vinyl_label', 'label_id', 'vinyl_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }
}
