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
        Schema::create('academic_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendant_id')->constrained('attendants')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('archivo')->nullable(); // Path to uploaded document
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_activities');
    }
};
