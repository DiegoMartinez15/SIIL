<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    protected $table = "coordinadores";
    protected $fillable=['nombre','idusuario'];

    public function oferta(){
        return $this->hasMany('App/Oferta');
    }
}
