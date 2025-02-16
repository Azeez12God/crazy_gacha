<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserApiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginUserApiController extends Controller
{
    public function login(LoginUserApiRequest $request){
        Auth::attempt([
            'name'=>$request->name,
            'password'=>$request->password
        ]);

        $logueado = Auth::user();

        if(!$logueado){
            return response()->json([
               'message'=>'Usuario o contraseña incorrectos',
               'data'=>$logueado
            ]);
        }
        else{
            $token=$logueado->createToken('auth_token')->plainTextToken;
            return response()->json([
               'message'=>'Bienvenido a crazy gacha',
               'data'=>$logueado,
               'token'=>$token,
               'type_token'=>'Bearer'
            ]);
        }
    }

    public function logout(){
        if(Auth::user()->tokens()->delete()){
            return response()->json([
               'message'=>'Sesión cerrada',
               'data'=>null
            ]);
        }
        else{
            return response()->json([
                'message'=>'No se ha podido cerrar sesión',
                'data'=>null
            ]);
        }
    }
}
