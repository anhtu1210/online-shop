<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone_number',
        'address',
        'amount_shipping',
        'amount_coupon',
        'total_price',
        'status',
        'note',
        'payment_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function details()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')
            ->withPivot(['name', 'price', 'tax', 'quantity']);
    }
}
