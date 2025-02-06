<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redactor extends Model
{
    use HasFactory;

    protected $table = 'redactores';

    protected $fillable = [
        'nombre',
        'email',
        'telefono', // Ajusta los campos según la migración
    ];
}
