<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    protected $table = "areas";
    protected $fillable=['nombre'];

    public function empresa(){
        return $this->hasMany('App/Empresa');
    }
}
