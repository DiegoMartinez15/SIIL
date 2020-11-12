<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Empresa;

class EmpresaController extends Controller
{
    public function index(){
        //$empresa =Empresa::orderBy('id','DESC')->get();
        //return $empresa;

        //$empresa = Empresa::join('areas','empresas.idarea','=','areas.id')
        //->join('coordinadores','empresas.idcoordinador','=','coodinadores.id')
         // ->select('empresas.id','empresas.nombre','empresas.direccion','empresas.telefono','empresas.encargado','empresas.idarea','empresas.idcoordinador',
        //'areas.nombre as idarea','coordinadores.nombre as idcoordinador')->get();
        $empresa = Empresa::join('areas','empresas.idarea', '=', 'areas.id')
        ->join('coordinadores', 'empresas.idcoordinador', '=', 'coordinadores.id')
        ->select('empresas.id','empresas.nombre','empresas.direccion','empresas.telefono','empresas.encargado','empresas.idarea','empresas.idcoordinador','areas.nombre as idarea','coordinadores.nombre as idcoordinador')
        ->get();
       return $empresa;
  
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresa = new Empresa();
        $empresa->nombre = $request->nombre;
        $empresa->direccion = $request->direccion;
        $empresa->telefono = $request->telefono;
        $empresa->encargado = $request->encargado;
        $empresa->idarea = $request->idarea;
        $empresa->idcoordinador = $request->idcoordinador;
        $empresa->save();
    }

    public function update(Request $request)
    {
        $empresa = Empresa::findOrfail($request->id);
        $empresa->nombre = $request->nombre;
        $empresa->direccion = $request->direccion;
        $empresa->telefono = $request->telefono;
        $empresa->encargado = $request->encargado;
        $empresa->idarea = $request->idarea;
        $empresa->idcoordinador = $request->idcoordinador;
        $empresa->save();
    }
    public function delete(Request $request)
    {
        $empresa =Empresa::findOrfail($request->id);
        $empresa->delete();
        
    }
}
