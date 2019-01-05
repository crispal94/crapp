<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGruposTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos_trabajos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_referencia');
            $table->foreign('id_referencia')->references('id')->on('param_referenciales');
            $table->string('descripcion', 150);
            $table->string('valor', 150);
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
        Schema::dropIfExists('grupos_trabajos');
    }
}
