<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignedCriteriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_criterios', function (Blueprint $table) {
            $table->integer('proyecto_id')->unsigned();
            $table->integer('criterio_id')->unsigned();
            $table->integer('npuntos')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('proyecto_id')->references('id')->on('proyectos')
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
        Schema::dropIfExists('assigned_criterios');
    }
}
