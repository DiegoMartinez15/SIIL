<?php

namespace App\Http\Controllers;

use App\Areas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Areas::all();
        return $areas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     ** @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Areas $areas)
    {
        $area = new Areas();
        $area->nombre = $request->nombre;        
        $area->save();
        return $area;        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Areas  $areas
     * @return \Illuminate\Http\Response
     */
    public function show(Areas $areas)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Areas  $areas
     * @return \Illuminate\Http\Response
     */
    public function edit(Areas $areas)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Areas  $areas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Areas $areas,$id)
    {    
        $area =Areas::findOrfail($id);
        $area->nombre = $request->nombre;        
        $area->save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Areas  $areas
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Areas $areas)
    {
        $area =Areas::findOrfail($request->id);
        $area->delete();   
    }
    public function destroy($id){
        $area =Areas::findOrfail($id);
        $area->delete();
    }
}
