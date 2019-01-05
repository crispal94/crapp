<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoPrioridadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_prioridad', function (Blueprint $table) {
            $table->increments('id');
            $table->string('valor', 150);
            $table->string('descripcion', 150);
            $table->integer('valor_minimo');
            $table->integer('valor_maximo');
            $table->integer('tiempo_alerta');
            $table->string('color',10);
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
        Schema::dropIfExists('tipo_prioridad');
    }
}
