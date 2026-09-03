<?php

namespace App\Models;
use App\Models\StockMovement;
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
    public function movements()
{
    return $this->hasMany(StockMovement::class);
}
}
