@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto bg-slate-900 p-8 rounded-3xl border border-slate-700 shadow-2xl">
    <h2 class="text-2xl font-bold mb-6 text-green-400 uppercase tracking-tight">Nuevo {{ ucfirst($tipo) }}</h2>

    <form action="{{ route('admin.repuestos.store', $tipo) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-800/40 p-6 rounded-2xl border border-slate-700">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Imagen</label>
                <input type="file" name="imagen" class="w-full text-white bg-slate-900 p-2 rounded-lg border border-slate-700">
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase">Código Interno</label>
                    <input type="text" name="codigo_interno" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-2 text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase">Marca</label>
                    <select name="marca_id" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-2 text-white">
                        @foreach($marcas as $m)
                            <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase">Precio Lista ($)</label>
                <input type="number" step="0.01" name="precio_lista_dolares" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-2 text-green-400 font-mono">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase">Descripción</label>
                <textarea name="descripcion" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-2 text-white" rows="1"></textarea>
            </div>
        </div>

        <div class="bg-slate-800/60 p-6 rounded-2xl border border-slate-700">
            <h3 class="text-xs font-black text-slate-400 uppercase mb-4 tracking-widest">Especificaciones Técnicas</h3>

            @if($tipo == 'bendix')
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div><label class="text-xs text-slate-500 uppercase">Código ZEN</label><input type="text" name="codigo_zen" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Dientes</label><input type="number" name="dientes" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Estrías</label><input type="number" name="estrias" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Sentido</label><select name="sentido" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"><option value="horario">Horario</option><option value="antihorario">Antihorario</option></select></div>
                    <div><label class="text-xs text-slate-500 uppercase">Ø Externo</label><input type="number" step="0.01" name="diametro_externo" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Ø Interno</label><input type="number" step="0.01" name="diametro_interno" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Largo</label><input type="number" step="0.01" name="largo" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                </div>
            @elseif($tipo == 'inducido')
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div><label class="text-xs text-slate-500 uppercase">Voltaje (V)</label><input type="number" name="voltaje" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Largo (mm)</label><input type="number" step="0.01" name="largo" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Ø Externo</label><input type="number" step="0.01" name="diametro_externo" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Estrías</label><input type="number" name="estrias" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Delgas</label><input type="number" name="delgas" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Cod. Original</label><input type="text" name="codigo_original" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                </div>
            @elseif($tipo == 'regulador')
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-xs text-slate-500 uppercase">Sistema</label><input type="text" name="sistema" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Voltaje</label><input type="number" name="voltaje" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Terminales</label><input type="number" name="terminales" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-xs text-slate-500 uppercase">Circuito</label><input type="text" name="circuito" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div class="flex items-center space-x-2 pt-6">
                        <input type="checkbox" name="capacitor" value="1" class="w-5 h-5 accent-green-500">
                        <label class="text-xs text-slate-500 uppercase font-bold">Lleva Capacitor</label>
                    </div>
                </div>
            @endif
        </div>

        {{-- BOTONES DE ACCIÓN --}}
        <div class="flex flex-col md:flex-row gap-4">
            <button type="submit" class="flex-1 bg-green-500 text-black font-black py-4 rounded-2xl uppercase hover:bg-green-400 transition-all shadow-lg">
                Registrar {{ ucfirst($tipo) }}
            </button>

            <a href="{{ route('admin.repuestos.index', $tipo) }}" class="flex-1 bg-red-600 text-white font-black py-4 rounded-2xl uppercase hover:bg-red-500 transition-all text-center flex items-center justify-center shadow-lg shadow-red-500/20">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection