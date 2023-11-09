<?php

use App\Models\Lesson;
use App\Models\Member;
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
        Schema::create('completed_lessons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Lesson::class);
            $table->foreignIdFor(Member::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_lessons');
    }
};
