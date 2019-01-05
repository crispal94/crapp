<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSegActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seg_actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_cabecera');
            $table->foreign('id_cabecera')->references('id')->on('cab_actividad');
            $table->unsignedInteger('id_detalle');
            $table->foreign('id_detalle')->references('id')->on('det_actividad');
            $table->unsignedInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('estado');
            $table->unsignedInteger('id_prioridad');
            $table->foreign('id_prioridad')->references('id')->on('tipo_prioridad');
            $table->timestamp('fechacump')->useCurrent();
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
        Schema::dropIfExists('seg_actividades');
    }
}
