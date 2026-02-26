<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|min:8',
        ]);

        $hashedPassword=Hash::make($request->password);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$hashedPassword
        ]);
        $token=$user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'user'=>$user,
            'message'=>'registerd successfully',
            'token'=>$token
        ],201);
    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        $user=User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                'message'=>'Invalid credentials'
            ],401);
        }
        $token=$user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'user'=>$user,
            'message'=>'login successfully',
            'token'=>$token
        ],200);
    }
}
