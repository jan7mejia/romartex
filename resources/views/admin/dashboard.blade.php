@extends('layouts.admin')

@section('admin_content')
<div class="mb-10">
    <h2 class="text-4xl font-extrabold text-white">Bienvenido, {{ Auth::user()->nombre }}</h2>
    <p class="text-slate-400">Panel de control de inventario y ventas Romartex.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-admin-card p-6 rounded-3xl border border-slate-700 hover:border-green-500 transition-all group shadow-lg">
        <div class="flex justify-between items-start mb-4">
            <span class="text-4xl">⚙️</span>
            <span class="bg-green-500/10 text-green-500 text-xs font-bold px-3 py-1 rounded-full border border-green-500/20">{{ $cantBendix }} Registrados</span>
        </div>
        <h3 class="text-xl font-bold mb-4 text-white">Bendix</h3>
        <a href="{{ route('admin.repuestos.index', ['tipo' => 'bendix']) }}" class="block text-center bg-slate-800 text-slate-300 group-hover:bg-green-500 group-hover:text-black py-2 rounded-xl font-bold transition-all">Gestionar CRUD</a>
    </div>

    <div class="bg-admin-card p-6 rounded-3xl border border-slate-700 hover:border-blue-500 transition-all group shadow-lg">
        <div class="flex justify-between items-start mb-4">
            <span class="text-4xl">⚡</span>
            <span class="bg-blue-500/10 text-blue-500 text-xs font-bold px-3 py-1 rounded-full border border-blue-500/20">{{ $cantInducidos }} Registrados</span>
        </div>
        <h3 class="text-xl font-bold mb-4 text-white">Inducidos</h3>
        <a href="{{ route('admin.repuestos.index', ['tipo' => 'inducido']) }}" class="block text-center bg-slate-800 text-slate-300 group-hover:bg-blue-500 group-hover:text-black py-2 rounded-xl font-bold transition-all">Gestionar CRUD</a>
    </div>

    <div class="bg-admin-card p-6 rounded-3xl border border-slate-700 hover:border-purple-500 transition-all group shadow-lg">
        <div class="flex justify-between items-start mb-4">
            <span class="text-4xl">🔌</span>
            <span class="bg-purple-500/10 text-purple-500 text-xs font-bold px-3 py-1 rounded-full border border-purple-500/20">{{ $cantReguladores }} Registrados</span>
        </div>
        <h3 class="text-xl font-bold mb-4 text-white">Reguladores</h3>
        <a href="{{ route('admin.repuestos.index', ['tipo' => 'regulador']) }}" class="block text-center bg-slate-800 text-slate-300 group-hover:bg-purple-500 group-hover:text-black py-2 rounded-xl font-bold transition-all">Gestionar CRUD</a>
    </div>
</div>

<div class="bg-admin-card rounded-3xl border border-slate-700 overflow-hidden shadow-2xl">
    <div class="p-6 border-b border-slate-700 flex justify-between items-center bg-slate-900/50">
        <h3 class="text-lg font-bold text-white tracking-tight">Última Actividad de Vendedores</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-950 text-slate-500 text-xs uppercase tracking-widest">
                <tr>
                    <th class="p-5">Vendedor</th>
                    <th class="p-5">Fecha</th>
                    <th class="p-5">Total Venta</th>
                    <th class="p-5 text-center">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($ultimasVentas as $venta)
                <tr class="hover:bg-slate-800/40 transition-colors">
                    <td class="p-5 font-bold text-slate-200">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-[10px] text-white">
                                {{ substr($venta->nombre, 0, 1) }}{{ substr($venta->apellido, 0, 1) }}
                            </div>
                            {{ $venta->nombre }} {{ $venta->apellido }}
                        </div>
                    </td>
                    <td class="p-5 text-slate-400 text-sm">{{ date('d M, Y H:i', strtotime($venta->fecha)) }}</td>
                    <td class="p-5 text-green-400 font-black font-mono">${{ number_format($venta->total, 2) }}</td>
                    <td class="p-5 text-center">
                        <a href="{{ route('admin.ventas.detalle', $venta->id) }}" class="text-xs bg-slate-800 border border-slate-700 text-white px-4 py-2 rounded-xl font-bold hover:bg-white hover:text-black transition-all">
                            Ver Detalle
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-10 text-center text-slate-500 italic">No hay ventas registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection