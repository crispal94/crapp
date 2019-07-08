<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesHorarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades_horario', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_responsable');
            $table->foreign('id_responsable')->references('id')->on('users');
            $table->unsignedInteger('id_tipoactivdad');
            $table->foreign('id_tipoactivdad')->references('id')->on('tipo_actividades');
            $table->string('lugar', 250);
            $table->string('descripcion', 1000);
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
        Schema::dropIfExists('actividades_horario');
    }
}
