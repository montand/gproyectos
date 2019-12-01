<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElementosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elementos', function (Blueprint $table) {
            $table->Increments('id')->unsigned();
            $table->integer('criterio_id')->unsigned()->nullable();
            $table->string('cnombre');
            $table->tinyInteger('npuntos')->unsigned();
            $table->timestamps();

            $table->foreign('criterio_id')->references('id')->on('criterios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elementos');
    }
}
