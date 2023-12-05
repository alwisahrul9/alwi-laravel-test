<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function index()
    {
        return view('index.index');
    }

    public function details($id)
    {
        return view('details.index', compact('id'));
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        // Data validation
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // If email and password correct, then redirect page to dashboard
        if(Auth::attempt($credential)){
            $request->session()->regenerate();
 
            return redirect()->intended('/');
        } else {
            // if email and password wrong, back to login page
            return redirect()->back()->with('failed', 'Email or Password wrong!');
        }
    }

    public function logoutProcess(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        // User redirect to login page
        return redirect('/login');
    }
}
