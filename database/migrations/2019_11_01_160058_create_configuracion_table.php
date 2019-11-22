<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cnom_empresa');
            $table->smallInteger('nejercicio_actual')->unsigned();
            $table->tinyInteger('ntemporalidad')->unsigned()
               ->comment('Temporalidad para calcular los años, máximo 5');
            $table->smallInteger('nano_inicial')->unsigned()->nullable();
            $table->tinyInteger('ncriteriosxescenario')->unsigned();
        });

        DB::table('configuracion')->insert(array('id'=>'1','cnom_empresa'=>'AS14 Consultores','nejercicio_actual'=>'2019','ntemporalidad'=>'3','nano_inicial'=>'2019','ncriteriosxescenario'=>'5'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuracion');
    }
}
