<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(string $locale)
    {
        return view('auth.login', compact('locale'));
    }

    public function login(string $locale, Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->isEmployer()) {
                return redirect()->route('home', $locale);
            }

            return redirect()->route('home', $locale);
        }

        return back()->withErrors([
            'email' => 'Pogrešan email ili lozinka.',
        ])->onlyInput('email');
    }

    public function logout(string $locale, Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home', $locale);
    }
}
