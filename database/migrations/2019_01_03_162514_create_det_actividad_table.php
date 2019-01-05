<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetActividadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_actividad', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_cabecera');
            $table->foreign('id_cabecera')->references('id')->on('cab_actividad');
            $table->unsignedInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('estado');
            $table->unsignedInteger('id_prioridad');
            $table->foreign('id_prioridad')->references('id')->on('tipo_prioridad');
            $table->string('descripcion', 150);
            $table->timestamp('fechacab')->useCurrent();
            $table->timestamp('fechainicio')->useCurrent();
            $table->timestamp('fechafin')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('det_actividad');
    }
}
