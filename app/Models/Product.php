<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'price_sale',
        'category_id',
        'brand_id',
        'is_featured',
        'is_show_home',
        'sku',
        'barcode',
        'track_qty',
        'qty',
        'status',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'product_id');
    }

    public function details()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id',)
            ->withPivot(['name', 'price', 'tax', 'quantity']);
    }

    protected $cat = [
        'status' => 'boolean',
    ];
}
