<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'amount'];

    protected $table = 'carts';

    public function products() {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }

    public function user() {
        return $this->hasMany(User::class, 'id');
    }
}
