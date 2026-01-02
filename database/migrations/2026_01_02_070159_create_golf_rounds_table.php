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
        Schema::create('golf_rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('golf_course_id')->constrained()->cascadeOnDelete();
            $table->date('date_played');
            $table->integer('eagles')->default(0);
            $table->integer('birdies')->default(0);
            $table->integer('pars')->default(0);
            $table->integer('putts');
            $table->integer('bogeys')->default(0);
            $table->integer('double_bogeys_or_worse')->default(0);
            $table->integer('score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('golf_rounds');
    }
};
