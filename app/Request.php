<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = ['user_id', 'product_id', 'total_amout'];

    public function product() {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }

    public function user() {
        return $this->hasMany(User::class, 'id');
    }
}
