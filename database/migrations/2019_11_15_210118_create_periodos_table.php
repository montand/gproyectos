<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('ano')->unsigned();
            $table->decimal('ntope_costo',18,2);
            $table->decimal('ntope_rh',18,2);
            $table->boolean('activo')->default('0');
        });

        DB::table('periodos')->insert(array('id'=>'1','ano'=>'2019','ntope_costo'=>'150000000','ntope_rh'=>'60000','activo'=>'1'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periodos');
    }
}
