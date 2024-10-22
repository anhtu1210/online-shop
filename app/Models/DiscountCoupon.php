<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DiscountCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'max_uses',
        'max_uses_user',
        'type',
        'discount_amount',
        'min_amount',
        'status',
        'start_at',
        'expires_at',
    ];

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s')
        );
    }
}
