<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_informes', function (Blueprint $table) {
            $table->id();
            $table->string('acudiente');
            $table->string('estudiante');
            $table->string('becado');
            $table->decimal('valor');
            $table->decimal('descuento');
            $table->decimal('abono');
            $table->decimal('pendiente');
            $table->decimal('plataforma');
            $table->date('fecha')->nullable();
            $table->text('comprobante')->nullable();
            $table->text('observacion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_informes');
    }
};
