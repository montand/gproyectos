<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriterioescenariodetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterio_escenariodet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('escenariodet_id')->unsigned();
            $table->integer('criterio_id')->unsigned();
            $table->integer('npuntos')->unsigned();
            $table->integer('ntotpuntos')->unsigned();
            $table->timestamps();

            $table->foreign('escenariodet_id')->references('id')->on('escenariosdet')
               ->onDelete('cascade');
            $table->foreign('criterio_id')->references('id')->on('criterios')
               ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escenariostot');
    }
}
