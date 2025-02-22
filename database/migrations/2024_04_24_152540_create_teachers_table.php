<?php

use App\Models\Group;
use App\Models\TypeTeacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('apellido');
            $table->string('email');
            $table->string('image')->nullable();
            $table->string('telefono');
            $table->string('estado');
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();
            $table->foreignIdFor(TypeTeacher::class)->constrained();
            $table->timestamps();
        });
    }    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
