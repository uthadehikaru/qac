<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberBatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_batch', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('batch_id')->constrained();
            $table->timestamp('approved_at')->nullable();
            $table->string('session')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_batch');
    }
}
