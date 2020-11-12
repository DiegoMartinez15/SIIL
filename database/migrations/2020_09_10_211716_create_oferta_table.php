<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oferta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cargo',100);
            $table->string('salario',100);
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresas');
            $table->integer('idrequisitos')->unsigned();
            $table->foreign('idrequisitos')->references('id')->on('requisitos');
            $table->integer('idcordinador')->unsigned();
            $table->foreign('idcordinador')->references('id')->on('coordinadores');
            
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
        Schema::dropIfExists('oferta');
    }
}
