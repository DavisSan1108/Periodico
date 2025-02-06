<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    protected $fillable = [
        'contenido',
        'usuario_id',
        'noticia_id',
        'fecha' // Ajusta los campos según la migración
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function noticia()
    {
        return $this->belongsTo(Noticia::class, 'noticia_id');
    }
}
