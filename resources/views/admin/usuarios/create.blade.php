@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto bg-slate-900 p-8 rounded-3xl border border-slate-700 shadow-2xl">
    <h2 class="text-2xl font-bold mb-6 text-green-400 uppercase tracking-tight">Registrar Nuevo Vendedor</h2>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500 rounded-2xl">
            <ul class="list-disc list-inside text-red-500 text-sm font-bold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.usuarios.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-800/40 p-6 rounded-2xl border border-slate-700">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Juan" required 
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-green-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Apellido</label>
                <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Ej: Perez" required 
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-green-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Celular</label>
                <input type="text" name="celular" value="{{ old('celular') }}" placeholder="Ej: 70000000" 
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-green-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="vendedor@romartex.com" required 
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-green-500 outline-none transition-all">
            </div>
        </div>

        <div class="bg-slate-800/40 p-6 rounded-2xl border border-slate-700">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Contraseña de Acceso</label>
            <input type="password" name="password" required 
                class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-green-500 outline-none transition-all" 
                placeholder="Mínimo 3 caracteres">
        </div>

        <div class="flex flex-col md:flex-row gap-4 pt-4 border-t border-slate-800">
            <button type="submit" class="flex-1 bg-green-500 text-black font-black py-4 rounded-2xl uppercase hover:bg-green-400 transition-all shadow-lg shadow-green-500/20">
                Guardar Vendedor
            </button>
            <a href="{{ route('admin.usuarios.index') }}" class="flex-1 bg-slate-800 text-white font-black py-4 rounded-2xl uppercase hover:bg-slate-700 transition-all text-center flex items-center justify-center border border-slate-700">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection