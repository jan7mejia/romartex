@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto bg-slate-900 p-8 rounded-3xl border border-slate-700 shadow-2xl">
    {{-- ENCABEZADO ESTILO REPUESTOS --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-yellow-400 uppercase tracking-tight">
            Editar Vendedor: {{ $usuario->nombre }} {{ $usuario->apellido }}
        </h2>
        <span class="bg-slate-800 text-slate-400 px-4 py-1 rounded-full text-xs font-mono">ID USUARIO: #{{ $usuario->id }}</span>
    </div>

    {{-- ERRORES DE VALIDACIÓN --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-500/20 border border-red-500 text-red-200 rounded-xl text-sm font-bold">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARIO DE ACTUALIZACIÓN --}}
    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- CONTENEDOR DE DATOS PERSONALES --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-800/40 p-6 rounded-2xl border border-slate-700">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required 
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-yellow-500 outline-none transition-colors">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Apellido</label>
                <input type="text" name="apellido" value="{{ old('apellido', $usuario->apellido) }}" required 
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-yellow-500 outline-none transition-colors">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Celular</label>
                <input type="text" name="celular" value="{{ old('celular', $usuario->celular) }}" placeholder="Ej: 70000000"
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-yellow-500 outline-none transition-colors">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required 
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-yellow-500 outline-none font-mono">
            </div>
        </div>

        {{-- CONTENEDOR DE SEGURIDAD (CONTRASEÑA) --}}
        <div class="bg-slate-800/60 p-6 rounded-2xl border border-slate-700">
            <h3 class="text-xs font-black text-slate-400 uppercase mb-4 tracking-widest border-b border-slate-700 pb-2">
                Seguridad de la Cuenta
            </h3>
            <div class="space-y-2">
                <label class="block text-xs font-bold text-yellow-500 uppercase">Nueva Contraseña (Opcional)</label>
                <input type="password" name="password" 
                    class="w-full bg-slate-950 border border-slate-700 rounded-xl p-3 text-white focus:border-yellow-500 outline-none shadow-inner" 
                    placeholder="Dejar en blanco para mantener la actual">
                <p class="text-[10px] text-slate-500">Si deseas cambiar el acceso, escribe la nueva clave (mín. 3 caracteres).</p>
            </div>
        </div>

        {{-- BOTONES LIMPIOS (SIN ICONOS) --}}
        <div class="flex flex-col md:flex-row gap-4 pt-4 border-t border-slate-800">
            <button type="submit" class="flex-1 bg-yellow-500 text-black font-black py-4 rounded-2xl uppercase hover:bg-yellow-400 transition-all shadow-lg shadow-yellow-500/20">
                Guardar Cambios
            </button>
            
            <a href="{{ route('admin.usuarios.index') }}" class="flex-1 bg-slate-800 text-white font-black py-4 rounded-2xl uppercase hover:bg-slate-700 transition-all text-center flex items-center justify-center border border-slate-700">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection