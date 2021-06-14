<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHasCategories extends Model
{
    protected $fillable = [
        'product_id', 'category_id'
    ];

    protected $table = 'product_has_categories';

    public static function category() {
        return $this->hasOne(Category::class, 'category_id', 'id');
    }
}
