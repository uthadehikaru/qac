<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('provinces')){
            Schema::create('provinces', function (Blueprint $table) {
                $table->string('id',2)->primary();
                $table->string('name');
            });
        }
        
        if(!Schema::hasTable('regencies')){
            Schema::create('regencies', function (Blueprint $table) {
                $table->string('id',4)->primary();
                $table->string('province_id',2)->index();
                $table->string('name');
            });
        }
        
        if(!Schema::hasTable('districts')){
            Schema::create('districts', function (Blueprint $table) {
                $table->string('id',7)->primary();
                $table->string('regency_id',4)->index();
                $table->string('name');
            });
        }
        
        if(!Schema::hasTable('villages')){
            Schema::create('villages', function (Blueprint $table) {
                $table->string('id',10)->primary();
                $table->string('district_id',7)->index();
                $table->string('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('villages');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('regencies');
        Schema::dropIfExists('provinces');
    }
};
