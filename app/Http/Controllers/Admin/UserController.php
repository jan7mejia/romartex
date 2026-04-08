<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $sucursalId = auth()->user()->sucursal_id;
        
        $usuarios = DB::table('usuarios')
            ->where('sucursal_id', $sucursalId)
            ->where('id', '!=', auth()->id())
            ->get();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $mensajes = [
            'nombre.required'   => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'email.required'    => 'El correo es obligatorio.',
            'email.email'       => 'Formato de correo inválido.',
            'email.unique'      => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'Contraseña: mínimo 3 caracteres.',
            'celular.max'       => 'Celular: máximo 20 caracteres.',
        ];

        $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email'    => 'required|string|email|max:150|unique:usuarios',
            'password' => 'required|string|min:3',
            'celular'  => 'nullable|string|max:20',
        ], $mensajes);

        DB::table('usuarios')->insert([
            'nombre'      => $request->nombre,
            'apellido'    => $request->apellido,
            'celular'     => $request->celular,
            'email'       => $request->email,
            'password'    => $request->password, 
            'rol'         => 'vendedor', 
            'sucursal_id' => auth()->user()->sucursal_id, 
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Vendedor registrado.');
    }

    public function edit($id)
    {
        $usuario = DB::table('usuarios')->where('id', $id)->first();
        
        if (!$usuario || $usuario->sucursal_id != auth()->user()->sucursal_id) {
            return redirect()->route('admin.usuarios.index')->with('error', 'No tienes permiso.');
        }

        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $mensajes = [
            'nombre.required'   => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'email.required'    => 'El correo es obligatorio.',
            'email.email'       => 'Formato de correo inválido.',
            'email.unique'      => 'Este correo ya lo usa otro usuario.',
            'password.min'      => 'Contraseña: mínimo 3 caracteres.',
            'celular.max'       => 'Celular: máximo 20 caracteres.',
        ];

        $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email'    => 'required|email|unique:usuarios,email,'.$id,
            'celular'  => 'nullable|string|max:20',
            'password' => 'nullable|string|min:3',
        ], $mensajes);

        $data = [
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'celular'  => $request->celular,
            'email'    => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        DB::table('usuarios')->where('id', $id)->update($data);

        return redirect()->route('admin.usuarios.index')->with('success', 'Datos actualizados.');
    }

    public function destroy($id)
    {
        DB::table('usuarios')
            ->where('id', $id)
            ->where('sucursal_id', auth()->user()->sucursal_id)
            ->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado.');
    }
}