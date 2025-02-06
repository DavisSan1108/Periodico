<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $table = 'noticias';

    protected $fillable = [
        'titulo',
        'contenido',
        'autor_id',
        'categoria_id',
        'fecha_publicacion' // Ajusta los campos según la migración
    ];

    public function autor()
    {
        return $this->belongsTo(Redactor::class, 'autor_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
