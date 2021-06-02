<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public $timestamps = ['created_at', 'updated_at', 'dispatched_at', 'confirmed_at'];

    protected $fillable = ['transaction_id', 'total', 'address_id', 'confirmed_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'product_id', 'order_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    public static function findByUUID(string $uuid)
    {
        return self::where('transaction_id', $uuid)->first();
    }
}
