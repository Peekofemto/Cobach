<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $filleable = [
        'numero_control', 'nombre', 'email'
    ];
}
