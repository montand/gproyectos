<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignedElementosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('assigned_elementos', function (Blueprint $table) {
        //     $table->integer('criterio_id')->unsigned();
        //     $table->integer('elemento_id')->unsigned();
        //     $table->timestamps();
        // });

        // Schema::table('assigned_elementos', function ($table) {
        //     $table->foreign('criterio_id')->references('id')->on('criterios')->onDelete('cascade');
        //     $table->foreign('elemento_id')->references('id')->on('elementos')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assigned_elementos');
    }
}
