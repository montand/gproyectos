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
            $table->bigIncrements('id');
            $table->string('cclave',15);
            $table->string('cnombre',150);
            $table->string('cdescripcion')->nullable();
            $table->string('cjustificacion')->nullable();
            $table->decimal('ncosto',18,2);
            $table->tinyInteger('nduracion')->unsigned();
            $table->integer('unidades_rh')->unsigned();
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
        Schema::dropIfExists('proyectos');
    }
}