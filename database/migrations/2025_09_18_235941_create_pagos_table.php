<?php

use App\Models\Apprentice;
use App\Models\MetodoPago;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Apprentice::class)->constrained();
            $table->decimal('monto', 10, 2);
            $table->foreignIdFor(MetodoPago::class)->constrained();
            $table->enum('dinero', ['Ingresado', 'Egresado']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
