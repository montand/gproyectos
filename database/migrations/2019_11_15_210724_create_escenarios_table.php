<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscenariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escenarios', function (Blueprint $table) {
            $table->Increments('id')->unsigned();
            $table->string('cnombre')->required();
            $table->decimal('ntotcosto',18,2);
            $table->integer('ntotrh');
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
        Schema::dropIfExists('escenarios');
    }
}
