@extends('layouts.admin')

@section('admin_content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
    <div>
        <h2 class="text-5xl font-black capitalize text-white tracking-tight">Gestión de {{ $tipo }}</h2>
        <p class="text-slate-300 font-medium text-xl mt-2">Inventario por Marca y Sucursal - Romartex</p>
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
                <th class="p-6 text-center">Stock Sucursal</th>
                <th class="p-6">Especificaciones Técnicas Completas</th>
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
                <div class="flex flex-col gap-2">
                    <span class="text-xs text-slate-500 font-mono">ID PM: #{{ $r->pm_id }}</span>
                    <span class="bg-blue-500/20 border border-blue-500/40 px-4 py-1 rounded-xl text-blue-300 text-xl font-black w-fit">
                        {{ $r->codigo_interno }}
                    </span>
                    <span class="text-white font-bold text-lg uppercase tracking-wide">
                        {{ $r->marca_nombre }}
                    </span>
                </div>
            </td>

            {{-- STOCK POR SUCURSAL --}}
            <td class="p-6">
                <div class="flex flex-col items-center justify-center bg-slate-950 p-4 rounded-3xl border border-slate-800 min-w-[100px]">
                    <span class="text-[10px] text-slate-500 uppercase font-black mb-1">Disponible</span>
                    <span class="{{ $r->stock_sucursal > 0 ? 'text-green-400' : 'text-red-500' }} text-4xl font-black font-mono">
                        {{ $r->stock_sucursal }}
                    </span>
                </div>
            </td>

            {{-- ESPECIFICACIONES TÉCNICAS (TODAS) --}}
            <td class="p-6">
                <div class="grid grid-cols-2 gap-2 text-xs">
                    
                    @if($tipo == 'bendix')
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Dientes: <b class="text-white text-sm">{{ $r->dientes }}</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Estrías: <b class="text-white text-sm">{{ $r->estrias }}</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Sentido: <b class="text-white text-sm">{{ $r->sentido }}</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Largo: <b class="text-white text-sm">{{ $r->largo }}mm</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Ø Ext: <b class="text-white text-sm">{{ $r->diametro_externo }}mm</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Ø Int: <b class="text-white text-sm">{{ $r->diametro_interno }}mm</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700 col-span-2 text-blue-400">Cod. ZEN: <b>{{ $r->codigo_zen ?? 'N/A' }}</b></div>

                    @elseif($tipo == 'inducido')
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Voltaje: <b class="text-white text-sm">{{ $r->voltaje }}V</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Largo: <b class="text-white text-sm">{{ $r->largo }}mm</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Ø Ext: <b class="text-white text-sm">{{ $r->diametro_externo }}mm</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Estrías: <b class="text-white text-sm">{{ $r->estrias }}</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Delgas: <b class="text-white text-sm">{{ $r->delgas ?? 'N/A' }}</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700 col-span-2 text-blue-400">Cod. Original: <b>{{ $r->codigo_original ?? 'N/A' }}</b></div>

                    @elseif($tipo == 'regulador')
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Sistema: <b class="text-white text-sm">{{ $r->sistema }}</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Voltaje: <b class="text-white text-sm">{{ $r->voltaje }}V</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Terminales: <b class="text-white text-sm">{{ $r->terminales }}</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700">Circuito: <b class="text-white text-sm">{{ $r->circuito }}</b></div>
                        <div class="bg-slate-800/50 p-2 rounded-lg border border-slate-700 col-span-2">
                            Capacitor: <b class="{{ $r->capacitor ? 'text-green-400' : 'text-slate-500' }}">{{ $r->capacitor ? 'SÍ' : 'NO' }}</b>
                        </div>
                    @endif

                </div>
            </td>

            {{-- PRECIO --}}
            <td class="p-6">
                <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800">
                    <span class="text-emerald-400 font-black text-2xl font-mono">
                        ${{ number_format($r->precio_lista_dolares, 2) }}
                    </span>
                </div>
            </td>

            {{-- ACCIONES --}}
            <td class="p-6">
                <div class="flex flex-col items-center gap-2">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('admin.repuestos.edit', [$tipo, $r->pm_id]) }}"
                           class="bg-blue-600 p-3 rounded-xl hover:scale-110 transition text-lg shadow-lg">
                           ✏️
                        </a>

                        @if($r->es_eliminable)
                            <form action="{{ route('admin.repuestos.destroy', $r->pm_id) }}" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de eliminar este repuesto?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-600 p-3 rounded-xl hover:scale-110 transition text-lg shadow-lg">
                                    🗑️
                                </button>
                            </form>
                        @else
                            <button class="bg-slate-700 p-3 rounded-xl cursor-not-allowed opacity-50 text-lg" title="No se puede borrar: tiene ventas asociadas">
                                🔒
                            </button>
                        @endif
                    </div>

                    @if(!$r->es_eliminable)
                        <span class="text-[9px] text-red-500 font-bold uppercase tracking-tighter bg-red-500/10 px-2 py-1 rounded border border-red-500/20">
                            Bloqueado (Vendido)
                        </span>
                    @endif
                </div>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="6" class="p-24 text-center">
                <div class="flex flex-col items-center gap-4 opacity-40">
                    <span class="text-8xl">📦</span>
                    <p class="text-white text-2xl font-bold">No hay registros en esta sucursal</p>
                </div>
            </td>
        </tr>
        @endforelse
        </tbody>

    </table>
</div>
@endsection