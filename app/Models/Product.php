<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'quantity',
        'minimum_stock',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
