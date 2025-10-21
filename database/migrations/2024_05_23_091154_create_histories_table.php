<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cantidad');
            $table->integer('year');
            $table->integer('mes');
            $table->integer('total');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
