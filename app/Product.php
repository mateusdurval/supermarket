<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category_id', 'amount', 'price', 'sale', 'image', 'brand', 'description'
    ];

    public function product_has_categories() {
        return $this->hasMany(ProductHasCategories::class, 'product_id', 'id');
    }
}
