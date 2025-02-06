<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('suscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('planes')->onDelete('cascade');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->boolean('estado')->default(true);
            $table->decimal('monto', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suscripciones');
    }
};

