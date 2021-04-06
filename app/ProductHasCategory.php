<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHasCategory extends Model
{
    protected $fillable = [
        'category'
    ];

    protected $table = 'product_has_category';
}
