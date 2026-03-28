@extends('layouts.admin')

@section('admin_content')
<div class="max-w-5xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Detalle de Venta #{{ str_pad($venta->id, 5, '0', STR_PAD_LEFT) }}</h2>
            <p class="text-slate-400 font-medium font-mono">📅 {{ date('d/m/Y H:i', strtotime($venta->fecha)) }}</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-slate-800 text-white px-6 py-3 rounded-2xl font-bold hover:bg-white hover:text-black transition-all border border-slate-700">
            ⬅ Volver al Panel
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl">
            <h3 class="text-xs font-black text-slate-500 uppercase mb-4 tracking-widest">Vendedor Responsable</h3>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center text-green-500 font-bold border border-green-500/30">
                    {{ substr($venta->nombre, 0, 1) }}{{ substr($venta->apellido, 0, 1) }}
                </div>
                <div>
                    <p class="text-white font-bold">{{ $venta->nombre }} {{ $venta->apellido }}</p>
                    <p class="text-slate-500 text-xs">{{ $venta->email }}</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl flex justify-between items-center">
            <div>
                <h3 class="text-xs font-black text-slate-500 uppercase mb-1 tracking-widest">Total Venta</h3>
                <p class="text-4xl font-black text-green-400 font-mono">${{ number_format($venta->total, 2) }}</p>
            </div>
        </div>

        <div class="lg:col-span-3 bg-slate-900 rounded-3xl border border-slate-800 overflow-hidden shadow-2xl">
            <table class="w-full text-left">
                <thead class="bg-slate-950 text-slate-500 text-[10px] uppercase tracking-[0.2em]">
                    <tr>
                        <th class="p-5">Producto</th>
                        <th class="p-5">Tipo</th>
                        <th class="p-5 text-center">Cant.</th>
                        <th class="p-5">Precio</th>
                        <th class="p-5 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach($detalles as $d)
                    <tr class="hover:bg-slate-800/30">
                        <td class="p-5">
                            <div class="flex flex-col">
                                <span class="text-white font-bold">{{ $d->codigo }}</span>
                                <span class="text-slate-500 text-[10px] uppercase font-black">{{ $d->marca_nombre }}</span>
                            </div>
                        </td>
                        <td class="p-5">
                            <span class="bg-slate-800 text-slate-400 px-3 py-1 rounded text-[10px] font-black uppercase">
                                {{ $d->tipo }}
                            </span>
                        </td>
                        <td class="p-5 text-center text-white font-bold">{{ $d->cantidad }}</td>
                        <td class="p-5 text-slate-400">${{ number_format($d->precio_final, 2) }}</td>
                        <td class="p-5 text-right text-green-400 font-black">${{ number_format($d->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection