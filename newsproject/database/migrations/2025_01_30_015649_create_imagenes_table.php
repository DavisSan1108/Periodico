<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('imagenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('noticia_id')->constrained('noticias')->onDelete('cascade');
            $table->foreignId('autor_id')->constrained('fotografos')->onDelete('cascade');
            $table->string('url');
            $table->string('titulo')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imagenes');
    }
};

