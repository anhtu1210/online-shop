<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'parent_id',
        'status',
    ];


    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(){
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function descendantsAndSelf($id)
    {
        return $this->descendantsAndSelfQuery($id)->get();
    }

    public function descendantsAndSelfQuery($id)
    {
        return $this->where('parent_id', $id);
    }

    protected  $cat = [
        'status' => 'boolean',
    ];


}
