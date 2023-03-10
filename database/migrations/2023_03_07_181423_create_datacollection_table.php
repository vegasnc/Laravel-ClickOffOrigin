<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatacollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datacollection', function (Blueprint $table) {
            $table->id();
            $table->string('asset', 191)->nullable();
            $table->string('latitude', 191)->nullable();
            $table->string('longitude', 45)->nullable();
            $table->string('address')->nullable();
            $table->string('autoaddress')->nullable();
            $table->string('status')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('action')->nullable();
            $table->string('client')->nullable();
            $table->string('color', 45)->nullable();
            $table->string('description')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datacollection');
    }
}
