<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',50);
            $table->string('direccion',100);
            $table->string('telefono',8);
            $table->string('encargado',50);

            $table->integer('idarea')->unsigned();
            $table->foreign('idarea')->references('id')->on('areas');

            $table->integer('idcoordinador')->unsigned();
            $table->foreign('idcoordinador')->references('id')->on('coordinadores');

          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
