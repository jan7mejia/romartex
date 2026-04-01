<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin() {
        // Si ya está logueado, redirigimos según su rol
        if (Auth::check()) {
            return (Auth::user()->rol === 'admin') 
                ? redirect('/admin/dashboard') 
                : redirect('/catalogo');
        }
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buscamos al usuario en la tabla 'usuarios' 
        $user = User::where('email', $request->email)
                    ->where('password', $request->password) 
                    ->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            
            // Guardamos la sucursal en la sesión para usarla en ventas y stock
            session(['sucursal_id' => $user->sucursal_id]);

            // Redirigir según el campo 'rol' (admin o vendedor)
            if ($user->rol === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            
            return redirect()->intended('/catalogo');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros de Romartex.',
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}