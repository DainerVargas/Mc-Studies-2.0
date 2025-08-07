<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sedes', function (Blueprint $table) {
            $table->id();
            $table->string('sede');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('sedes');
    }
};
