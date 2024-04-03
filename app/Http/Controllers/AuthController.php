<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|max:255',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $request->session()->put('user_id', Auth::user()->id);
            $request->session()->put('user_email', Auth::user()->email);

            return redirect(route('dashboard'));
        }
        Session::flash('error', 'Invalid Credentials');
        return back();
    }

    public function logout() {
        Session::flush();
        Auth::logout();

        return redirect(route('index'));
    }
}
