@extends('layouts.admin')

@section('admin_content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
    <div>
        <h2 class="text-5xl font-black capitalize text-white tracking-tight">Gestión de {{ $tipo }}</h2>
        <p class="text-slate-300 font-medium text-xl mt-2">Inventario técnico especializado - Romartex</p>
    </div>

    <div class="flex gap-4">
        <a href="{{ route('admin.dashboard') }}" class="bg-slate-800 text-white px-6 py-3 rounded-2xl font-bold hover:bg-slate-700 transition border border-slate-700 shadow-lg flex items-center gap-2 text-lg">
            ⬅ Volver
        </a>

        <a href="{{ route('admin.repuestos.create', $tipo) }}" class="bg-green-500 text-black px-6 py-3 rounded-2xl font-black hover:bg-green-400 transition shadow-lg shadow-green-500/20 uppercase tracking-wider text-lg">
            + Nuevo {{ $tipo }}
        </a>
    </div>
</div>

@if(session('error') || session('success'))
<div class="mb-8 p-6 {{ session('error') ? 'bg-red-500/10 border-red-500/50 text-red-400' : 'bg-green-500/10 border-green-500/50 text-green-400' }} border-2 rounded-2xl flex items-center gap-4 font-bold text-xl">
    <span class="text-2xl">{{ session('error') ? '⚠️' : '✅' }}</span>
    <p>{{ session('error') ?? session('success') }}</p>
</div>
@endif

<div class="bg-slate-900 rounded-[2rem] border border-slate-800 overflow-hidden shadow-2xl">
    <table class="w-full text-left border-collapse">
        
        <thead class="bg-slate-950 text-slate-400 text-sm uppercase tracking-wider border-b border-slate-800">
            <tr>
                <th class="p-6">Vista</th>
                <th class="p-6">Identificación</th>
                <th class="p-6">Especificaciones</th>
                <th class="p-6">Precio</th>
                <th class="p-6 text-center">Acciones</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-800/50">
        @forelse($repuestos as $r)
        <tr class="hover:bg-blue-500/[0.05] transition-all group">

            {{-- IMAGEN --}}
            <td class="p-6">
                @if($r->imagen)
                    <img src="{{ asset('imagenes/' . $r->imagen) }}" class="w-28 h-28 object-cover rounded-2xl border-2 border-slate-700 shadow-xl group-hover:border-blue-500 transition-all">
                @else
                    <div class="w-28 h-28 bg-slate-800 rounded-2xl flex items-center justify-center text-5xl border-2 border-slate-700">
                        ⚙️
                    </div>
                @endif
            </td>

            {{-- IDENTIFICACIÓN --}}
            <td class="p-6">
                <div class="flex flex-col gap-3">
                    <span class="text-sm text-slate-400 font-mono uppercase">Ref #{{ $r->pm_id }}</span>

                    <span class="bg-blue-500/20 border border-blue-500/40 px-4 py-2 rounded-xl text-blue-300 text-2xl font-black w-fit">
                        {{ $r->codigo_interno }}
                    </span>

                    <span class="text-white font-bold text-lg uppercase">
                        {{ $r->marca_nombre }}
                    </span>
                </div>
            </td>

            {{-- ESPECIFICACIONES --}}
            <td class="p-6">
                <div class="flex flex-wrap gap-3 max-w-xl text-base">

                    @if($tipo == 'bendix')
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">Dientes: <b>{{ $r->dientes }}</b></span>
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">Sentido: <b>{{ $r->sentido }}</b></span>
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">Estrías: <b>{{ $r->estrias }}</b></span>
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">ZEN: <b>{{ $r->codigo_zen ?? 'N/A' }}</b></span>

                        <div class="w-full grid grid-cols-3 gap-2 mt-2 text-sm">
                            <span class="bg-slate-800 px-3 py-2 rounded-lg">Ø Ext: <b>{{ $r->diametro_externo }}</b></span>
                            <span class="bg-slate-800 px-3 py-2 rounded-lg">Ø Int: <b>{{ $r->diametro_interno }}</b></span>
                            <span class="bg-slate-800 px-3 py-2 rounded-lg">Largo: <b>{{ $r->largo }}</b></span>
                        </div>

                    @elseif($tipo == 'inducido')
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">Voltaje: <b>{{ $r->voltaje }}V</b></span>
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">Largo: <b>{{ $r->largo }}</b></span>
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">Ø Ext: <b>{{ $r->diametro_externo }}</b></span>
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">Estrías: <b>{{ $r->estrias }}</b></span>
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">Delgas: <b>{{ $r->delgas ?? 'N/A' }}</b></span>

                    @elseif($tipo == 'regulador')
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">Sistema: <b>{{ $r->sistema }}</b></span>
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">Voltaje: <b>{{ $r->voltaje }}V</b></span>
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">Terminales: <b>{{ $r->terminales }}</b></span>
                        <span class="bg-slate-800 px-3 py-2 rounded-xl">Circuito: <b>{{ $r->circuito }}</b></span>

                        <span class="bg-slate-800 px-3 py-2 rounded-xl">
                            {{ $r->capacitor ? 'Con capacitor' : 'Sin capacitor' }}
                        </span>
                    @endif

                </div>
            </td>

            {{-- PRECIO --}}
            <td class="p-6">
                <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800">
                    <span class="text-green-400 font-black text-3xl font-mono">
                        ${{ number_format($r->precio_lista_dolares, 2) }}
                    </span>
                </div>
            </td>

            {{-- ACCIONES --}}
            <td class="p-6">
                <div class="flex justify-center gap-3">
                    
                    <a href="{{ route('admin.repuestos.edit', [$tipo, $r->pm_id]) }}"
                       class="bg-blue-600 p-4 rounded-2xl hover:scale-110 transition text-xl shadow-lg">
                        ✏️
                    </a>

                    <form action="{{ route('admin.repuestos.destroy', $r->pm_id) }}" method="POST"
                          onsubmit="return confirm('¿Eliminar este repuesto?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-600 p-4 rounded-2xl hover:scale-110 transition text-xl shadow-lg">
                            🗑️
                        </button>
                    </form>

                </div>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="5" class="p-24 text-center">
                <div class="flex flex-col items-center gap-4 opacity-40">
                    <span class="text-8xl">📦</span>
                    <p class="text-white text-2xl font-bold">No hay registros</p>
                </div>
            </td>
        </tr>
        @endforelse
        </tbody>

    </table>
</div>
@endsection