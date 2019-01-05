<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitacoraActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_cabecera');
            $table->foreign('id_cabecera')->references('id')->on('cab_actividad');
              $table->timestamp('fechaemis')->useCurrent();
            $table->string('nombre', 150);
            $table->string('descripcion', 150);
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
        Schema::dropIfExists('bitacora_actividades');
    }
}
