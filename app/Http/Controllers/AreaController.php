<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Area;

class AreaController extends Controller
{
    public function index(){
        $area =Area::orderBy('id','DESC')->get();
        return $area;
  
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $area = new Area();
        $area->nombre = $request->nombre;        
        $area->save();
    }

    public function update(Request $request)
    {
        $area =Area::findOrfail($request->id);
        $area->nombre = $request->nombre;        
        $area->save();
    }

    public function delete(Request $request)
    {
        $area =Area::findOrfail($request->id);
        $area->delete();
        
    }


    
}
