<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->Increments('id')->unsigned();
            $table->string('cclave',15);
            $table->string('cnombre',500);
            $table->string('cdescripcion',1000)->nullable();
            $table->string('cjustificacion',1000)->nullable();
            $table->decimal('ncosto',18,2)->nullable()->default('0');
            $table->tinyInteger('nduracion')->unsigned()->nullable()->default('0');
            $table->integer('unidades_rh')->unsigned()->nullable()->default('0');
            $table->integer('tema_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('tema_id')->references('id')->on('temas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyectos');
    }
}
