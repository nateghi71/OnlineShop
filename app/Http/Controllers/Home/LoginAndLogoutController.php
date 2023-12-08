<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAndLogoutController extends Controller
{
    public function index()
    {
        return view('home.logIn');
    }
    public function logIn(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials,$request->has('remember_me'))) {
            $request->session()->regenerate();
            return redirect()->intended();
        }

        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ])->withInput();
    }
    public function logOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home.index');
    }
}
