<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('profesi')->nullable();
            $table->string('pendidikan')->nullable();
        });
        Schema::table('member_batch', function (Blueprint $table) {
            $table->string('note')->nullable;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['profesi','pendidikan']);
        });
        
        Schema::table('member_batch', function (Blueprint $table) {
            $table->dropColumn(['note']);
        });
    }
}
