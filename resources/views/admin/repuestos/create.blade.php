@extends('layouts.admin')

@section('admin_content')
<div class="max-w-3xl mx-auto bg-admin-card p-8 rounded-3xl border border-slate-700 shadow-2xl">
    <h2 class="text-2xl font-bold mb-6 text-green-400 uppercase tracking-tighter">
        Añadir Nuevo {{ ucfirst($tipo) }}
    </h2>

    <form action="{{ route('admin.repuestos.store', $tipo) }}" method="POST" class="space-y-6">
        @csrf
        
        {{-- Datos Generales (Para todos) --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Código Producto</label>
                <input type="text" name="codigo" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-green-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Marca</label>
                <select name="marca_id" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-green-500 outline-none">
                    @foreach($marcas as $m)
                        <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Campos Específicos para BENDIX --}}
        @if($tipo == 'bendix')
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Dientes</label>
                <input type="number" name="dientes" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Estrías</label>
                <input type="number" name="estrias" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Sentido</label>
                <select name="sentido" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
                    <option value="horario">Horario</option>
                    <option value="antihorario">Anti-Horario</option>
                </select>
            </div>
        </div>
        @endif

        {{-- Campos Específicos para INDUCIDO --}}
        @if($tipo == 'inducido')
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Voltaje (V)</label>
                <input type="number" name="voltaje" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Largo (mm)</label>
                <input type="number" step="0.1" name="largo" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Diámetro (mm)</label>
                <input type="number" step="0.1" name="diametro" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
            </div>
        </div>
        @endif

        {{-- Campos Específicos para REGULADOR --}}
        @if($tipo == 'regulador')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Sistema</label>
                <input type="text" name="sistema" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Terminales</label>
                <input type="number" name="terminales" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
            </div>
        </div>
        @endif

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Precio ($)</label>
                <input type="number" step="0.01" name="precio" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white font-mono text-green-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nombre / Ref</label>
                <input type="text" name="nombre" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
            </div>
        </div>

        <button type="submit" class="w-full bg-green-500 text-black font-black py-4 rounded-2xl uppercase tracking-widest hover:bg-green-400 transition-all shadow-lg">
            Guardar {{ $tipo }} en Sistema
        </button>
        
        <a href="{{ route('admin.repuestos.index', $tipo) }}" class="block text-center text-slate-500 text-sm hover:underline">
            Cancelar y volver al listado
        </a>
    </form>
</div>
@endsection