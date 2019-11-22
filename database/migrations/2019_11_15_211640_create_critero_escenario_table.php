<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriteroEscenarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('critero_escenario', function (Blueprint $table) {
            $table->integer('escenario_id')->unsigned();
            $table->integer('criterio_id')->unsigned();
            $table->integer('npeso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('critero_escenario');
    }
}
