<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterUserApiController extends Controller
{
    public function register(StoreUserRequest $request){
        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password= Hash::make($request->password);
        $user->money=0;

        $user->save();

        Auth::attempt([
            'email'=>$user->email,
            'password'=>$user->password
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
           'message'=>'Usuario registrado correctamente',
           'data'=>$user,
           'token'=>$token,
           'token_type'=>'Bearer'
        ]);
    }
}
