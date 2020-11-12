<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Usuario;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $usuario =Usuario::join('tipos_usuarios','usuarios.idtipo_usuario','=','tipos_usuarios.id')
       ->select('usuarios.id','usuarios.nombre','usuarios.passwd','usuarios.estado','usuarios.idtipo_usuario',
       'tipos_usuarios.nombre as idtipo_usuario')->where('usuarios.estado','=','A')->get();

       return $usuario;
        //$usuario =Usuario::orderBy('id','DESC')->get();
        //return $usuario;
  
    }
        /**
     * Store a newly created resource in storage.
     ** @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, Usuario $usuarios)
    {
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;        
        $usuario->passwd = $request->passwd; 
        $usuario->estado ='A';
        $usuario->idtipo_usuario = 2;
        $usuario->save();
        return $usuario;
       
    }

    public function update(Request $request,Usuario $usuarios,$id)
    {
        $usuario =Usuario::findOrfail($request->id);
        $usuario->nombre = $request->nombre;        
        $usuario->passwd = $request->passwd; 
        $usuario->estado ='A';
        $usuario->idtipo_usuario = 2;
        $usuario->save();
        
    }

    public function destroy($id)
    {
        $usuario =Usuario::findOrfail($id);
        $usuario->delete();
        
    }

    public function getById(){
        $requisito=Usuario::where("idtipo_usuario",1)->get();
        return $requisito;
    }
}
