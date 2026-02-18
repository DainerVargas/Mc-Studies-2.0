<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (!Schema::hasColumn('register_hours', 'metodo')) {
            Schema::table('register_hours', function (Blueprint $table) {
                $table->string('metodo')->nullable()->after('pago');
            });
        }
    }

    public function down(): void
    {
        Schema::table('register_hours', function (Blueprint $table) {
            $table->dropColumn('metodo');
        });
    }
};
