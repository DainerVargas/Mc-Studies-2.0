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
        Schema::table('reunions', function (Blueprint $table) {
            $table->unsignedBigInteger('attendant_id')->nullable()->change();
            $table->unsignedBigInteger('apprentice_id')->nullable()->after('attendant_id');
            // Assuming the table name is apprentices
            $table->foreign('apprentice_id')->references('id')->on('apprentices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reunions', function (Blueprint $table) {
            $table->dropForeign(['apprentice_id']);
            $table->dropColumn('apprentice_id');
            $table->unsignedBigInteger('attendant_id')->nullable(false)->change();
        });
    }
};
