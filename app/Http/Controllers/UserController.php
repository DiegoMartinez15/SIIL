<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(Request $request){

        $input = $request->all();

        $input['password'] = Hash::make($request->password);

        User::create($input);
        return response()->json([
            'res' => true,
            'message' =>"Usuario creado correctamente"
        ],200);
    }

    public function login(Request $request){
        $user = User::whereEmail($request->email)->first();
        if(!is_null($user) && Hash::check($request->password, $user->password)){
            $token = $user->createToken('SIILv3')->accessToken;
            return response()->json([
                'res' => true,
                'token' => $token,
                'message' =>"Bienvenido al sistema ",
                'user' => $user
            ],200);
        }else{
            return response()->json([
                'res' => false,
                'message' =>"Lo siento no tienes permiso para ingresar al sitio"
            ],200);
        }
    }
    public function logout(){
        $user = auth()->user();
        $user->tokens->each(function ($token, $key){
            $token->delete();
        });
        
        $user->save();
        return response()->json([
            'res' => true,
            'message' =>"adios ",
            'user'=> $user
        ],200);
    }
}
