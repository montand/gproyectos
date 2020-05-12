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
            $table->Increments('id')->unsigned();
            $table->integer('escenario_id')->unsigned();
            $table->integer('proyecto_id')->unsigned();
            $table->integer('ntotpuntos')->unsigned();
            $table->boolean('excluir')->default('0');
            $table->timestamps();

            $table->foreign('escenario_id')->references('id')->on('escenarios')
               ->onDelete('cascade');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')
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
        Schema::dropIfExists('escenariosdet');
    }
}
