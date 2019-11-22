<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscenariosdetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escenariosdet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('escenario_id')->unsigned();
            $table->integer('criterio_id')->unsigned();
            $table->integer('proyecto_id')->unsigned();
            $table->integer('npuntos')->unsigned();
            $table->integer('ntotpuntos')->unsigned();
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
        Schema::dropIfExists('escenariosdet');
    }
}
