@extends('layouts.admin')

@section('admin_content')
<div class="mb-10">
    <h2 class="text-4xl font-extrabold text-white">Bienvenido, {{ Auth::user()->nombre }}</h2>
    <p class="text-slate-400">Panel de control de inventario y ventas Romartex.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-admin-card p-6 rounded-3xl border border-slate-700 hover:border-green-500 transition-all group">
        <div class="flex justify-between items-start mb-4">
            <span class="text-4xl">⚙️</span>
            <span class="bg-green-500/10 text-green-500 text-xs font-bold px-3 py-1 rounded-full">{{ $cantBendix }} Registrados</span>
        </div>
        <h3 class="text-xl font-bold mb-4">Bendix</h3>
        <a href="{{ route('admin.repuestos.index', ['tipo' => 'bendix']) }}" class="block text-center bg-slate-800 group-hover:bg-green-500 group-hover:text-black py-2 rounded-xl font-bold transition-all">Gestionar CRUD</a>
    </div>

    <div class="bg-admin-card p-6 rounded-3xl border border-slate-700 hover:border-blue-500 transition-all group">
        <div class="flex justify-between items-start mb-4">
            <span class="text-4xl">⚡</span>
            <span class="bg-blue-500/10 text-blue-500 text-xs font-bold px-3 py-1 rounded-full">{{ $cantInducidos }} Registrados</span>
        </div>
        <h3 class="text-xl font-bold mb-4">Inducidos</h3>
        <a href="{{ route('admin.repuestos.index', ['tipo' => 'inducido']) }}" class="block text-center bg-slate-800 group-hover:bg-blue-500 group-hover:text-black py-2 rounded-xl font-bold transition-all">Gestionar CRUD</a>
    </div>

    <div class="bg-admin-card p-6 rounded-3xl border border-slate-700 hover:border-purple-500 transition-all group">
        <div class="flex justify-between items-start mb-4">
            <span class="text-4xl">🔌</span>
            <span class="bg-purple-500/10 text-purple-500 text-xs font-bold px-3 py-1 rounded-full">{{ $cantReguladores }} Registrados</span>
        </div>
        <h3 class="text-xl font-bold mb-4">Reguladores</h3>
        <a href="{{ route('admin.repuestos.index', ['tipo' => 'regulador']) }}" class="block text-center bg-slate-800 group-hover:bg-purple-500 group-hover:text-black py-2 rounded-xl font-bold transition-all">Gestionar CRUD</a>
    </div>
</div>

<div class="bg-admin-card rounded-3xl border border-slate-700 overflow-hidden">
    <div class="p-6 border-b border-slate-700">
        <h3 class="text-lg font-bold">Última Actividad de Vendedores</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-900/50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="p-4">Vendedor</th>
                    <th class="p-4">Fecha</th>
                    <th class="p-4">Total Venta</th>
                    <th class="p-4">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @foreach($ultimasVentas as $venta)
                <tr class="hover:bg-slate-800/30">
                    <td class="p-4 font-bold">{{ $venta->vendedor }}</td>
                    <td class="p-4 text-slate-400 text-sm">{{ $venta->fecha }}</td>
                    <td class="p-4 text-green-400 font-mono">${{ number_format($venta->total, 2) }}</td>
                    <td class="p-4"><button class="text-xs bg-slate-700 px-3 py-1 rounded-lg">Ver Detalle</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection