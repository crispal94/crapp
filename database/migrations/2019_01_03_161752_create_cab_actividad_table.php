<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCabActividadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cab_actividad', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_userogroup');
            $table->unsignedInteger('id_prioridad');
            $table->foreign('id_prioridad')->references('id')->on('tipo_prioridad');
            $table->unsignedInteger('id_tipoactividad');
            $table->foreign('id_tipoactividad')->references('id')->on('tipo_actividades');
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
        Schema::dropIfExists('cab_actividad');
    }
}
