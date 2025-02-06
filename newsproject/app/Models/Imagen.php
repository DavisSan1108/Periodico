<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $table = 'imagenes';

    protected $fillable = [
        'url',
        'noticia_id',
        'descripcion' // Ajusta los campos según la migración
    ];

    public function noticia()
    {
        return $this->belongsTo(Noticia::class, 'noticia_id');
    }
}
