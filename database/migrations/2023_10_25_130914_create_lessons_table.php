<?php

use App\Models\Ecourse;
use App\Models\Section;
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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->uuid('lesson_uu');
            $table->foreignIdFor(Ecourse::class);
            $table->foreignIdFor(Section::class);
            $table->string('subject');
            $table->string('thumbnail')->nullable();
            $table->unsignedInteger('order_no')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
