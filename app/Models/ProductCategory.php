<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use NodeTrait;
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'name', 'slug'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
