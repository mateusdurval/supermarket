<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'number',
        'full_name',
        'expiration_date',
        'cvc',
        'cpf',
        'flag'
    ];

    protected $table = 'cards';
}
