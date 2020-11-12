<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $table = "oferta";
    protected $fillable=['cargo','idempresa','idrequisio'];

    //por la realacion inversa con empresas
    public function empresas(){
        return $this->belongsTo('app/Empresa');
    }


    
    //por la realacion inversa con requisitos
    public function requisitos(){
        return $this->belongsTo('app/RequisitosOferta');
    }
}
