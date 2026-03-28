@extends('layouts.admin')

@section('admin_content')
<div class="flex justify-between items-center mb-10">
    <div>
        <h2 class="text-4xl font-extrabold capitalize text-white">Gestión de {{ $tipo }}</h2>
        <p class="text-slate-400">Listado completo de inventario para la base de datos Romartex.</p>
    </div>
    <div class="flex gap-4">
        <a href="{{ route('admin.dashboard') }}" class="bg-slate-800 text-white px-6 py-3 rounded-xl font-bold hover:bg-slate-700 transition border border-slate-700">
            ⬅ Volver al Inicio
        </a>
        <a href="{{ route('admin.repuestos.create', $tipo) }}" class="bg-green-500 text-black px-6 py-3 rounded-xl font-bold hover:bg-green-400 transition shadow-lg shadow-green-500/20">
            + Nuevo {{ ucfirst($tipo) }}
        </a>
    </div>
</div>

<div class="bg-slate-900 rounded-3xl border border-slate-700 overflow-hidden shadow-2xl">
    <table class="w-full text-left">
        <thead class="bg-slate-950 text-slate-500 text-xs uppercase tracking-widest">
            <tr>
                <th class="p-5">Imagen</th>
                <th class="p-5">Código / Marca</th>
                <th class="p-5">Especificaciones Técnicas Detalladas</th>
                <th class="p-5">Precio</th>
                <th class="p-5 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800">
            @forelse($repuestos as $r)
            <tr class="hover:bg-slate-800/40 transition-colors">
                {{-- COLUMNA IMAGEN --}}
                <td class="p-5">
                    @if($r->imagen)
                        <img src="{{ asset('imagenes/' . $r->imagen) }}" class="w-16 h-16 object-cover rounded-lg border border-slate-700 shadow-md">
                    @else
                        <div class="w-16 h-16 bg-slate-800 rounded-lg border border-slate-700 flex items-center justify-center text-2xl">
                            ⚙️
                        </div>
                    @endif
                </td>

                {{-- COLUMNA CÓDIGO Y MARCA --}}
                <td class="p-5">
                    <div class="flex flex-col gap-1">
                        <span class="font-mono bg-slate-800 border border-slate-700 px-3 py-1 rounded-lg text-green-400 text-sm w-fit">
                            {{ $r->codigo }}
                        </span>
                        <span class="text-white font-bold ml-1">{{ $r->marca_nombre }}</span>
                    </div>
                </td>

                {{-- COLUMNA TÉCNICA COMPLETA --}}
                <td class="p-5 text-sm text-slate-300">
                    <div class="flex flex-wrap gap-2">
                        @if($tipo == 'bendix')
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-200">Dientes: <b>{{ $r->dientes }}</b></span>
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-200">Estrías: <b>{{ $r->estrias }}</b></span>
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-blue-400 font-bold uppercase">{{ $r->sentido }}</span>
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-400">Ø Ext: {{ $r->diametro_externo }}</span>
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-400">Ø Int: {{ $r->diametro_interno }}</span>
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-400">Largo: {{ $r->largo }}</span>
                        
                        @elseif($tipo == 'inducido')
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-green-400 font-bold">{{ $r->voltaje }}V</span>
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-200">Largo: <b>{{ $r->largo }}mm</b></span>
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-200">Ø: <b>{{ $r->diametro }}mm</b></span>
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-400">Estrías: {{ $r->estrias }}</span>
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-400">Delgas: {{ $r->delgas }}</span>
                            @if($r->codigo_original)
                                <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-yellow-500 font-mono text-xs">Orig: {{ $r->codigo_original }}</span>
                            @endif

                        @elseif($tipo == 'regulador')
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-200">Sistema: <b>{{ $r->sistema }}</b></span>
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-green-400 font-bold">{{ $r->voltaje }}V</span>
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-200">Term: <b>{{ $r->terminales }}</b></span>
                            <span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-400 italic">Circuito: {{ $r->circuito }}</span>
                            
                            {{-- LOGICA DE CAPACITOR --}}
                            @if($r->capacitor)
                                <span class="bg-blue-900/50 text-blue-300 border border-blue-700 px-2 py-1 rounded text-xs font-bold">CON CAPACITOR</span>
                            @else
                                <span class="bg-slate-800 text-slate-500 border border-slate-700 px-2 py-1 rounded text-xs font-bold uppercase">Sin Capacitor</span>
                            @endif
                        @endif
                    </div>
                </td>

                {{-- COLUMNA PRECIO --}}
                <td class="p-5 font-bold text-white text-lg">
                    <span class="text-green-500 text-sm mr-1">$</span>{{ number_format($r->precio_dolares, 2) }}
                </td>

                {{-- ACCIONES --}}
                <td class="p-5 text-center">
                    <div class="flex justify-center gap-3">
                        <a href="{{ route('admin.repuestos.edit', [$tipo, $r->producto_id]) }}" class="bg-slate-800 border border-slate-700 p-2.5 rounded-xl hover:bg-blue-600 hover:border-blue-500 transition-all group">
                            <span class="group-hover:scale-110 block">✏️</span>
                        </a>
                        <form action="{{ route('admin.repuestos.destroy', $r->producto_id) }}" method="POST" onsubmit="return confirm('¿Eliminar este repuesto definitivamente?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-slate-800 border border-slate-700 p-2.5 rounded-xl hover:bg-red-600 hover:border-red-500 transition-all group">
                                <span class="group-hover:scale-110 block">🗑️</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-20 text-center text-slate-500 italic">
                    No hay {{ $tipo }} registrados todavía en el sistema.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection