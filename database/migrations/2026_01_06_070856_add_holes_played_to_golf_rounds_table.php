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
        Schema::table('golf_rounds', function (Blueprint $table) {
            $table->integer('holes_played')->default(18)->after('golf_course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('golf_rounds', function (Blueprint $table) {
            $table->dropColumn('holes_played');
        });
    }
};
