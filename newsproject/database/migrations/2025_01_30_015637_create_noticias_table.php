<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('autor_id')->constrained('redactores')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('municipio_id')->constrained('municipios')->onDelete('cascade');
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('contenido');
            $table->boolean('es_premium')->default(false);
            $table->dateTime('fecha_publicacion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('noticias');
    }
};

