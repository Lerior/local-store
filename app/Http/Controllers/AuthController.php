<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request){

        $data = $request->validated();

        if(! Auth::attempt($data)){
            return response()->json(['message' => 'Credenciales inválidas o no autorizado.'], 401);
        }
        
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request) { 
        
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        
        return redirect()->route('login'); 
        }
}
