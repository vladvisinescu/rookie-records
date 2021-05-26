<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $table = 'addresses';

    protected $casts = [
        'default' => 'boolean'
    ];

    protected $fillable = [
        'address_1', 'address_2', 'town', 'county', 'country', 'postcode', 'user_id', 'type', 'default', 'uuid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'address_id', 'id');
    }
}
