<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category_id', 'amount', 'price', 'sale', 'image', 'brand', 'description'
    ];

    public function category() {
        return $this->hasOne(ProductHasCategory::class, 'id');
    }
}
