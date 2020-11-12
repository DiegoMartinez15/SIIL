<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('edad',100);
            $table->string('genero',100);
            $table->string('nivel_academico',100);
            $table->string('experiencia',100);
            $table->string('horario',100);
            $table->string('descripcion',100);
            $table->string('licencia',100);
           

            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresas');
            
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
        Schema::dropIfExists('requisitos');
    }
}
