<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coordinador;
use APP\Usuario;

class CoordinadorController extends Controller
{
    public function index(){
        

        $coordinador = Coordinador::join('tipos_usuarios','coordinadores.idusuario','=','tipos_usuarios.id')
        ->select('coordinadores.id','coordinadores.nombre','coordinadores.idusuario',
        'tipos_usuarios.nombre as idusuario')->get();
        
        return $coordinador;
        //$coordinador =Coordinador::orderBy('id','DESC')->get();
        //return $coordinador;
        
  
    }

    

    public function store(Request $request)
    {
        $coordinador = new Coordinador();
        $coordinador->nombre = $request->nombre;        
        $coordinador->idusuario =$request->idusuario;
        $coordinador->save();
    }

    public function update(Request $request)
    {
        $coordinador =Coordinador::findOrfail($request->id);
        $coordinador->nombre = $request->nombre;        
        $coordinador->idusuario =$request->idusuario;
        $coordinador->save();
    }

    public function delete(Request $request)
    {
        $coordinador =Coordinador::findOrfail($request->id);
        $coordinador->delete();
        
    }
}
