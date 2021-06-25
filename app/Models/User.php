<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Laravolt\Avatar\Avatar;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens, Billable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'full_name', 'avatar'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAvatarAttribute()
    {
        return (new Avatar)
            ->create(strtoupper($this->full_name))
            ->setBorder(0, '#eee')
            ->setBackground('#e5e7eb')
            ->setForeground('#9ca3af')
            ->toBase64();
    }

    public function routeNotificationForMail($notification)
    {
        return [$this->email => $this->full_name];
    }
}
