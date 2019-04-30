<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maestro extends Model
{
    protected $filleable = [
        'numero_control', 'nombre', 'email'
    ];
}
