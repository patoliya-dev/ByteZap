<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

         $user = User::where('email','=',$request->email)->first();
         if($user){
             if (Auth::attempt($credentials)) {
                 $request->session()->put('loginId', $user->id);
                 return redirect()->intended('/attendance-dashboard');
             }
         }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
