<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Address;

class UserHasAdresses extends Model
{
    protected $fillable = [
        'user_id', 'address_id'
    ];

    protected $table = 'user_has_adresses';

    public function adresses() {
        return $this->hasMany(Address::class, 'id');
    }
}
