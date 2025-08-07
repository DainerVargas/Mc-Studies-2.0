<?php

use App\Models\Attendant;
use App\Models\Becado;
use App\Models\Comprobante;
use App\Models\Group;
use App\Models\Level;
use App\Models\Modality;
use App\Models\Sede;
use App\Models\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apprentices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('apellido');
            $table->integer('edad');
            $table->string('email')->nullable();
            $table->string('documento')->nullable();
            $table->string('telefono')->nullable();
            $table->string('direccion');
            $table->string('imagen')->nullable();
            $table->date('fecha_nacimiento');
            $table->integer('plataforma')->nullable();
            $table->integer('fechaPlataforma')->nullable();  
            $table->boolean('estado')->nullable();
            $table->foreignIdFor(Level::class)->nullable();
            $table->foreignIdFor(Becado::class)->constrained();
            $table->integer('valor')->nullable();
            $table->integer('descuento')->nullable()->defaultValue(0);
            $table->string('observacion')->nullable();
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();
            $table->foreignIdFor(Attendant::class)->constrained()->nullable();
            $table->foreignIdFor(Modality::class)->constrained();
            $table->foreignIdFor(Group::class)->nullable()->constrained();
            $table->foreignIdFor(Sede::class)->nullable()->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apprentices');
    }
};
