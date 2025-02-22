<?php

use App\Models\Apprentice;
use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->format('d-m-Y');
            $table->string('estado');
            $table->text('observaciones');
            $table->foreignIdFor(Apprentice::class)->constrained();
            $table->foreignIdFor(Teacher::class)->constrained();
            $table->foreignIdFor(Group::class)->constrained();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
