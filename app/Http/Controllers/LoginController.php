<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            // Periksa apakah pengguna memiliki peran "Admin"
            if (Auth::user()->role->Name == 'Admin') {
                return redirect()->route('dashboard');
            } else if (Auth::user()->role->Name == 'Accounting') {
                return redirect()->route('report.index');
            } else {
                return redirect()->route('andon.index');
            }
        }

        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role->Name == 'Admin') {
                return redirect()->route('dashboard');
            } else if (Auth::user()->role->Name == 'Accounting') {
                return redirect()->route('report.index');
            } 
            else {
                return redirect()->route('andon.received');
            }
        }

        return back()->with('loginError', 'Username atau Password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}
