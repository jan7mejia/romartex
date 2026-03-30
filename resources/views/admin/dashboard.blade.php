@extends('layouts.admin')

@section('admin_content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
    {{-- ENCABEZADO MEJORADO: Texto más grande y legible --}}
    <div>
        <h2 class="text-6xl font-black italic tracking-tighter leading-none bg-gradient-to-r from-white via-slate-200 to-slate-500 bg-clip-text text-transparent mb-2">
            ROMARTEX
        </h2>
        <div class="flex items-center gap-3 mt-3">
            <span class="h-1.5 w-10 bg-[#4ade80] rounded-full"></span>
            <p class="text-xl text-slate-300 font-medium">
                Bienvenido, <span class="text-white font-bold text-2xl">{{ Auth::user()->nombre }}</span>. 
            </p>
        </div>
        <p class="text-lg text-slate-400 mt-1 ml-13">Gestión de inventario local.</p>
    </div>

    <div class="text-right">
        {{-- SEDE ACTIVA: Más grande y con mejor contraste --}}
        <span class="text-xs text-slate-400 uppercase tracking-[0.3em] font-black block mb-2">SEDE ACTIVA</span>
        <div class="bg-[#4ade80]/10 border-2 border-[#4ade80]/30 text-[#4ade80] px-6 py-3 rounded-2xl font-black flex items-center gap-3 shadow-xl text-lg">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#4ade80] opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-[#4ade80]"></span>
            </span>
            {{ $sucursalAdmin }}
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    {{-- Card Bendix --}}
    <div class="bg-[#0a0a0a] p-6 rounded-3xl border border-slate-800 hover:border-[#4ade80] transition-all group shadow-xl">
        <div class="flex justify-between items-start mb-4">
            <span class="text-4xl">⚙️</span>
            <span class="bg-[#4ade80]/10 text-[#4ade80] text-xs font-bold px-3 py-1 rounded-full border border-[#4ade80]/20">
                {{ $cantBendix }} Modelos con Stock
            </span>
        </div>
        <h3 class="text-2xl font-bold mb-4 text-white">Bendix</h3>
        <a href="{{ route('admin.repuestos.index', ['tipo' => 'bendix']) }}" class="block text-center bg-slate-900 text-slate-300 group-hover:bg-[#4ade80] group-hover:text-black py-4 rounded-2xl font-black text-sm uppercase tracking-widest transition-all">Ver Inventario</a>
    </div>

    {{-- Card Inducidos --}}
    <div class="bg-[#0a0a0a] p-6 rounded-3xl border border-slate-800 hover:border-blue-500 transition-all group shadow-xl">
        <div class="flex justify-between items-start mb-4">
            <span class="text-4xl">⚡</span>
            <span class="bg-blue-500/10 text-blue-500 text-xs font-bold px-3 py-1 rounded-full border border-blue-500/20">
                {{ $cantInducidos }} Modelos con Stock
            </span>
        </div>
        <h3 class="text-2xl font-bold mb-4 text-white">Inducidos</h3>
        <a href="{{ route('admin.repuestos.index', ['tipo' => 'inducido']) }}" class="block text-center bg-slate-900 text-slate-300 group-hover:bg-blue-500 group-hover:text-black py-4 rounded-2xl font-black text-sm uppercase tracking-widest transition-all">Ver Inventario</a>
    </div>

    {{-- Card Reguladores --}}
    <div class="bg-[#0a0a0a] p-6 rounded-3xl border border-slate-800 hover:border-purple-500 transition-all group shadow-xl">
        <div class="flex justify-between items-start mb-4">
            <span class="text-4xl">🔌</span>
            <span class="bg-purple-500/10 text-purple-500 text-xs font-bold px-3 py-1 rounded-full border border-purple-500/20">
                {{ $cantReguladores }} Modelos con Stock
            </span>
        </div>
        <h3 class="text-2xl font-bold mb-4 text-white">Reguladores</h3>
        <a href="{{ route('admin.repuestos.index', ['tipo' => 'regulador']) }}" class="block text-center bg-slate-900 text-slate-300 group-hover:bg-purple-500 group-hover:text-black py-4 rounded-2xl font-black text-sm uppercase tracking-widest transition-all">Ver Inventario</a>
    </div>
</div>

<div class="bg-[#0a0a0a] rounded-3xl border border-slate-800 overflow-hidden shadow-2xl">
    <div class="p-6 border-b border-slate-800 flex justify-between items-center bg-slate-900/30">
        <h3 class="text-xl font-bold text-white italic">Actividad Reciente en {{ $sucursalAdmin }}</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-black text-slate-400 text-xs uppercase tracking-[0.2em]">
                <tr>
                    <th class="p-6">Vendedor Responsable</th>
                    <th class="p-6">Fecha y Hora</th>
                    <th class="p-6">Monto Total</th>
                    <th class="p-6 text-center">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-900">
                @forelse($ultimasVentas as $venta)
                <tr class="hover:bg-slate-800/30 transition-colors">
                    <td class="p-6">
                        <div class="flex items-center gap-4">
                            {{-- Avatar más grande --}}
                            <div class="w-12 h-12 rounded-2xl bg-slate-800 flex items-center justify-center text-sm text-[#4ade80] font-black border-2 border-slate-700 shadow-inner">
                                {{ strtoupper(substr($venta->nombre, 0, 1)) }}{{ strtoupper(substr($venta->apellido, 0, 1)) }}
                            </div>
                            <div>
                                {{-- Nombre del vendedor más grande y claro --}}
                                <p class="text-lg font-black text-white leading-tight">{{ $venta->nombre }} {{ $venta->apellido }}</p>
                                <p class="text-xs text-[#4ade80] uppercase font-bold tracking-wider mt-0.5">Vendedor Autorizado</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-6 text-slate-300 text-base font-mono">
                        {{ date('d/m/Y H:i', strtotime($venta->fecha_hora)) }}
                    </td>
                    <td class="p-6">
                        <span class="text-[#4ade80] text-xl font-black font-mono tracking-tighter">Bs. {{ number_format($venta->total_venta, 2) }}</span>
                    </td>
                    <td class="p-6 text-center">
                        <a href="{{ route('admin.ventas.detalle', $venta->id) }}" class="text-xs bg-slate-800 hover:bg-white hover:text-black text-white px-6 py-3 rounded-xl font-black uppercase tracking-widest transition-all border border-slate-600 shadow-lg">
                            Ver Detalles
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-20 text-center">
                        <p class="text-slate-500 italic text-lg font-medium">No se registran ventas el día de hoy en {{ $sucursalAdmin }}.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection