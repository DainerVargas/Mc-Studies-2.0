<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reunions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendant_id')->constrained('attendants')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_programada');
            $table->enum('estado', ['pendiente', 'confirmada', 'completada', 'cancelada'])->default('pendiente');
            $table->text('respuesta_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reunions');
    }
};
