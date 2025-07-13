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
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Apprentice::class)->constrained();
            $table->foreignIdFor(Teacher::class)->constrained();
            $table->foreignIdFor(Group::class)->constrained();
            $table->float('listening');
            $table->float('writing');
            $table->float('reading');
            $table->float('speaking');
            $table->integer('semestre');
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qualifications');
    }
};
