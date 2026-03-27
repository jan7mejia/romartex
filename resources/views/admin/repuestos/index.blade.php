@extends('layouts.admin')

@section('admin_content')
<div class="flex justify-between items-center mb-10">
    <div>
        <h2 class="text-4xl font-extrabold capitalize text-white">Gestión de {{ $tipo }}</h2>
        <p class="text-slate-400">Listado de inventario para la base de datos Romartex.</p>
    </div>
    <a href="{{ route('admin.repuestos.create', $tipo) }}" class="bg-green-500 text-black px-6 py-3 rounded-xl font-bold hover:bg-green-400 transition shadow-lg shadow-green-500/20">
        + Nuevo {{ ucfirst($tipo) }}
    </a>
</div>

<div class="bg-admin-card rounded-3xl border border-slate-700 overflow-hidden shadow-2xl">
    <table class="w-full text-left">
        <thead class="bg-slate-900/50 text-slate-500 text-xs uppercase tracking-widest">
            <tr>
                <th class="p-5">Código</th>
                <th class="p-5">Marca</th>
                <th class="p-5">Especificaciones Técnicas</th>
                <th class="p-5">Precio</th>
                <th class="p-5 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800">
            @forelse($repuestos as $r)
            <tr class="hover:bg-slate-800/40 transition-colors">
                <td class="p-5">
                    <span class="font-mono bg-slate-800 border border-slate-700 px-3 py-1.5 rounded-lg text-green-400 text-sm">
                        {{ $r->codigo }}
                    </span>
                </td>
                <td class="p-5 text-white font-medium">{{ $r->marca_nombre }}</td>
                <td class="p-5 text-sm text-slate-300">
                    <div class="flex flex-wrap gap-2">
                        @if($tipo == 'bendix')
                            <span class="bg-slate-700/50 px-2 py-1 rounded">{{ $r->dientes }} Dientes</span>
                            <span class="bg-slate-700/50 px-2 py-1 rounded">{{ $r->estrias }} Estrías</span>
                            <span class="bg-slate-700/50 px-2 py-1 rounded text-blue-400 uppercase text-xs">{{ $r->sentido }}</span>
                        @elseif($tipo == 'inducido')
                            <span class="bg-slate-700/50 px-2 py-1 rounded">{{ $r->voltaje }}V</span>
                            <span class="bg-slate-700/50 px-2 py-1 rounded">{{ $r->largo }}mm Largo</span>
                            <span class="bg-slate-700/50 px-2 py-1 rounded">Ø{{ $r->diametro }}mm</span>
                        @elseif($tipo == 'regulador')
                            <span class="bg-slate-700/50 px-2 py-1 rounded">Sis: {{ $r->sistema }}</span>
                            <span class="bg-slate-700/50 px-2 py-1 rounded">{{ $r->voltaje }}V</span>
                            <span class="bg-slate-700/50 px-2 py-1 rounded">{{ $r->terminales }} Term.</span>
                        @endif
                    </div>
                </td>
                <td class="p-5 font-bold text-white text-lg">
                    <span class="text-green-500 text-sm mr-1">$</span>{{ number_format($r->precio_dolares, 2) }}
                </td>
                <td class="p-5">
                    <div class="flex justify-center gap-3">
                        <a href="{{ route('admin.repuestos.edit', [$tipo, $r->producto_id]) }}" class="bg-slate-800 border border-slate-700 p-2.5 rounded-xl hover:bg-blue-500 hover:border-blue-400 transition-all group">
                            <span class="group-hover:scale-110 block">✏️</span>
                        </a>
                        <form action="{{ route('admin.repuestos.destroy', $r->producto_id) }}" method="POST" onsubmit="return confirm('¿Eliminar este {{ $tipo }} de Romartex?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-slate-800 border border-slate-700 p-2.5 rounded-xl hover:bg-red-500 hover:border-red-400 transition-all group">
                                <span class="group-hover:scale-110 block">🗑️</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-20 text-center text-slate-500 italic">
                    No hay {{ $tipo }} registrados todavía.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection