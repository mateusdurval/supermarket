<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\StatusRequest;

class Request extends Model
{
    protected $fillable = [
        'user_id', 'address_id', 'card_id', 'status', 'checkout'
    ];

    protected $table = 'requests';

    public function address() {
        return $this->hasOne(Address::class, 'id');
    }

    public function card() {
        return $this->hasOne(Card::class, 'id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id');
    }
}
