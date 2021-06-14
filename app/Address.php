<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'cep',
        'state',
        'city',
        'district',
        'street',
        'number',
        'reference'
    ];

    protected $table = 'adresses';
}
