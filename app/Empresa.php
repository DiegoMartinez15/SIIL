<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = "empresas";
    protected $fillable=['nombre','direccion','telefono','encargado','idarea','idcoordinador'];

    public function ofertas(){
        return $this->hasMany('App/Oferta');
    }
}
