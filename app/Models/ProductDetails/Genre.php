<?php

namespace App\Models\ProductDetails;

use App\Models\ProductTypes\Vinyl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property string uuid
 */

class Genre extends Model
{
    use HasSlug;
    use HasFactory;

    protected $table = 'genres';

    protected $fillable = ['name'];

    public function findByNameOrCreate($query = '', $data = []): self
    {
        $genre = self::where('name', $query)->first();

        if(! $genre) {
            $genre = self::create($data);
        }

        return $genre;
    }

    public function vinyls()
    {
        return $this->belongsToMany(Vinyl::class, 'vinyl_genre', 'genre_id', 'vinyl_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }
}
