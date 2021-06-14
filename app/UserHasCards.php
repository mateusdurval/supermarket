<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHasCards extends Model
{
    protected $fillable = [
        'user_id', 'card_id'
    ];

    protected $table = 'user_has_cards';

    public function cards() {
        return $this->hasMany(Card::class, 'id');
    }
}
