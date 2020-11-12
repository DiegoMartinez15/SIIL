<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisitosOferta extends Model
{
    protected $table = "requisitos";
    protected $fillable=['edad','genero','nivel_academico','experiencia','horario','descripcion','licencia','idempresa'];

    public function ofertas(){
        return $this->hasMany('App/Oferta');
    }
}
