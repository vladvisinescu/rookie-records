<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $casts = [
        'is_default' => 'boolean'
    ];

    protected $fillable = [
        'address_1', 'address_2', 'town', 'county', 'country', 'postcode', 'user_id', 'type', 'default', 'uuid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
