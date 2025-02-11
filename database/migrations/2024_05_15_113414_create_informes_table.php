<?php

use App\Models\Apprentice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('informes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Apprentice::class)->constrained();
            $table->integer('abono');
            $table->string('urlImage')->nullable()->default(null);
            $table->date('fecha')->nullable();
            $table->date('fechaRegistro')->nullable();
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('informes');
    }
};
