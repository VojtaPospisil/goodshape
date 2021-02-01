<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parkings', function (Blueprint $table) {
            $table->id('id');
            $table->integer('gid');
            $table->decimal('lat');
            $table->decimal('lng');
            $table->string('name');
            $table->integer('numOfFreePlaces');
            $table->integer('numOfTakenPlaces');
            $table->boolean('pr');
            $table->integer('totalNumOfPlaces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parkings');
    }
}
