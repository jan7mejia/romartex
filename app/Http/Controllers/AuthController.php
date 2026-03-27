<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin() {
        // Si ya está logueado, lo mandamos a donde corresponde
        if (Auth::check()) {
            return (Auth::user()->rol === 'admin') ? redirect('/admin/dashboard') : redirect('/catalogo');
        }
        return view('auth.login');
    }

    public function login(Request $request) {
        // Buscamos el usuario en la tabla 'usuarios'
        $user = User::where('email', $request->email)
                    ->where('password', $request->password)
                    ->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            
            // Redirigir según el campo 'rol' de tu SQL
            if ($user->rol === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/catalogo');
        }

        return back()->withErrors(['email' => 'El correo o la contraseña no coinciden con nuestros registros.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}