<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'phone_number',
        'address',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($user) {
    //         static::creating(function ($user) {
    //             // $user->password = bcrypt($user->password);

    //             dd($user);
    //         });
    //         static::created(function ($user) {
    //             // $user->password = bcrypt($user->password);

    //             dd($user);
    //         });
    //         static::retrieved(function ($user) {
    //             // $user->password = bcrypt($user->password);

    //             dd($user);
    //         });
    //     });
    // }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // public function notifications()
    // {
    //     return $this->hasMany(DatabaseNotification::class, 'notifiable_id');
    // }
}
