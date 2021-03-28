<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = ['user_id', 'product_id', 'total_amout'];

    public function Product() {
        $this->belongsMany(Product::class, 'product_id', 'id');
    }
}
