<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class LoginController extends Controller
{
    // Create API Login and Register
    public function login(Request $request)
    {
        // Data validation
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // If email and password correct, then create token
        if(Auth::attempt($credential)){
            return response()->json([
                'token' => Auth::user()->createToken('user-token')->plainTextToken
            ]);
        }
        
        return response()->json([
            'message' => 'Credential not match'
        ]);
    }

    public function logout(Request $request){
        // Remove token
        $request->user()->currentAccessToken()->delete();
    }
}
