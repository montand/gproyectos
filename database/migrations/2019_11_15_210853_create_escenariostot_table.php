<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscenariostotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escenariostot', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('escenario_id')->unsigned();
            $table->integer('proyecto_id')->unsigned();
            $table->decimal('ncosto',18,2);
            $table->integer('unidades_rh');
            $table->integer('ntotalpuntos');
            $table->boolean('excluir')->default('0');
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
        Schema::dropIfExists('escenariostot');
    }
}
