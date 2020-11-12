<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Oferta;

class OfertaController extends Controller
{
    public function index(){
        
        $oferta = Oferta::orderBy('id','DESC')->get();
       return $oferta;
    }

}
