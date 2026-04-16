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
        Schema::table('academic_activities', function (Blueprint $table) {
            if (!Schema::hasColumn('academic_activities', 'comentario')) {
                $table->text('comentario')->nullable();
            }
            if (!Schema::hasColumn('academic_activities', 'calificacion')) {
                $table->string('calificacion')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_activities', function (Blueprint $table) {
            $table->dropColumn(['comentario', 'calificacion']);
        });
    }
};
