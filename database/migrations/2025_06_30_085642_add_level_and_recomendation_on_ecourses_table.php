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
        Schema::table('ecourses', function (Blueprint $table) {
            $table->unsignedTinyInteger('level')->default(1);
            $table->unsignedTinyInteger('recomendation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecourses', function (Blueprint $table) {
            $table->dropColumn('level');
            $table->dropColumn('recomendation');
        });
    }
};
