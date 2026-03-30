@extends('layouts.admin')

@section('admin_content')
<div class="max-w-6xl mx-auto px-4 py-6">
    {{-- ENCABEZADO --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <span class="text-blue-500 font-black tracking-[0.3em] text-xs uppercase mb-2 block">Resumen de Operación</span>
            <h2 class="text-5xl font-black text-white uppercase tracking-tighter leading-none">Venta #{{ str_pad($venta->id, 5, '0', STR_PAD_LEFT) }}</h2>
            <div class="flex flex-wrap items-center gap-4 mt-4">
                <p class="text-slate-400 text-lg font-mono">📅 {{ date('d/m/Y H:i', strtotime($venta->fecha)) }}</p>
                <span class="text-slate-700">|</span>
                <p class="text-green-500 text-sm font-bold uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full shadow-[0_0_10px_rgba(34,197,94,0.8)]"></span>
                    Sucursal: {{ $venta->sucursal_nombre }}
                </p>
            </div>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="group bg-slate-800 text-white px-8 py-4 rounded-2xl font-bold hover:bg-white hover:text-black transition-all duration-300 border border-slate-700 flex items-center gap-3">
            <span class="group-hover:-translate-x-1 transition-transform">⬅</span> Volver al Panel
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- CARD INFO VENDEDOR --}}
        <div class="bg-slate-900 p-8 rounded-[2.5rem] border border-slate-800 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <h3 class="text-xs font-black text-slate-500 uppercase mb-6 tracking-widest border-b border-slate-800 pb-4">Personal de Venta</h3>
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 bg-gradient-to-tr from-blue-600 to-blue-400 text-white rounded-2xl flex items-center justify-center text-2xl font-black shadow-xl shadow-blue-500/20">
                    {{ substr($venta->nombre, 0, 1) }}{{ substr($venta->apellido, 0, 1) }}
                </div>
                <div>
                    <p class="text-white text-xl font-bold leading-tight">{{ $venta->nombre }} {{ $venta->apellido }}</p>
                    <p class="text-slate-400 text-sm font-medium mt-1">{{ $venta->email }}</p>
                </div>
            </div>
        </div>

        {{-- CARD TOTAL --}}
        <div class="lg:col-span-2 bg-slate-900 p-8 rounded-[2.5rem] border border-slate-800 shadow-2xl flex flex-col md:flex-row justify-between items-center bg-gradient-to-br from-slate-900 via-slate-900 to-blue-900/10">
            <div class="mb-6 md:mb-0">
                <h3 class="text-xs font-black text-slate-500 uppercase mb-3 tracking-widest">Monto Total Liquidado</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-bold text-green-500">$</span>
                    <p class="text-6xl font-black text-green-400 font-mono tracking-tighter leading-none">{{ number_format($venta->total, 2) }}</p>
                </div>
            </div>
            <div class="text-right">
                <span class="text-slate-800 text-7xl font-black uppercase italic tracking-tighter select-none">ROMARTEX</span>
            </div>
        </div>

        {{-- TABLA DE PRODUCTOS --}}
        <div class="lg:col-span-3 bg-slate-900 rounded-[2.5rem] border border-slate-800 overflow-hidden shadow-2xl border-t-4 border-t-blue-600">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-950/80 backdrop-blur-md text-slate-400 text-xs uppercase tracking-[0.15em]">
                        <tr>
                            <th class="p-8">Detalle Técnico del Repuesto</th>
                            <th class="p-8 text-center">Tipo</th>
                            <th class="p-8 text-center">Cantidad</th>
                            <th class="p-8 text-right font-mono">P. Unitario</th>
                            <th class="p-8 text-right font-mono">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($detalles as $d)
                        <tr class="hover:bg-blue-500/[0.03] transition-all duration-300">
                            <td class="p-8">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="text-white font-black text-2xl tracking-tight">{{ $d->codigo }}</span>
                                        <span class="bg-yellow-500/10 text-yellow-500 text-[10px] px-3 py-1 rounded-full font-black uppercase border border-yellow-500/20">{{ $d->marca_nombre }}</span>
                                    </div>
                                    
                                    {{-- CARACTERÍSTICAS TÉCNICAS MEJORADAS --}}
                                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 bg-slate-950/60 p-5 rounded-2xl border border-slate-800/60 shadow-inner">
                                        @if($d->tipo == 'bendix')
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Cód. Zen:</span> <span class="text-slate-200 font-medium">{{ $d->codigo_zen ?? 'N/A' }}</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Dientes:</span> <span class="text-slate-200 font-medium">{{ $d->dientes }}T</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Estrías:</span> <span class="text-slate-200 font-medium">{{ $d->estrias }}</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Giro:</span> <span class="text-slate-200 font-medium">{{ ucfirst($d->sentido) }}</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Ø Ext/Int:</span> <span class="text-slate-200 font-medium">{{ $d->b_ext }}mm / {{ $d->b_int }}mm</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Largo:</span> <span class="text-slate-200 font-medium">{{ $d->b_largo }}mm</span></div>
                                        @elseif($d->tipo == 'inducido')
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Voltaje:</span> <span class="text-slate-200 font-medium">{{ $d->i_voltaje }}V</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Largo:</span> <span class="text-slate-200 font-medium">{{ $d->i_largo }}mm</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Ø Externo:</span> <span class="text-slate-200 font-medium">{{ $d->i_ext }}mm</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Estrías:</span> <span class="text-slate-200 font-medium">{{ $d->i_estrias }}</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Delgas:</span> <span class="text-slate-200 font-medium">{{ $d->i_delgas ?? 'N/A' }}</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Cód. Orig:</span> <span class="text-slate-200 font-medium">{{ $d->i_original ?? 'N/A' }}</span></div>
                                        @elseif($d->tipo == 'regulador')
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Sistema:</span> <span class="text-slate-200 font-medium">{{ $d->r_sistema }}</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Voltaje:</span> <span class="text-slate-200 font-medium">{{ $d->r_voltaje }}V</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Terminales:</span> <span class="text-slate-200 font-medium">{{ $d->r_term }}</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Circuito:</span> <span class="text-slate-200 font-medium">{{ $d->r_circuito }}</span></div>
                                            <div class="flex gap-2 text-sm"><span class="text-slate-500 font-bold uppercase text-[10px] w-20">Capacitor:</span> <span class="text-slate-200 font-medium">{{ $d->r_cap ? 'Sí Incluye' : 'No Incluye' }}</span></div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="p-8 text-center">
                                <span class="bg-slate-800 text-slate-300 px-4 py-2 rounded-xl text-[11px] font-black uppercase border border-slate-700 tracking-tighter">
                                    {{ $d->tipo }}
                                </span>
                            </td>
                            <td class="p-8 text-center">
                                <span class="text-white font-black text-3xl">{{ $d->cantidad }}</span>
                            </td>
                            <td class="p-8 text-right font-mono text-slate-400 text-lg">
                                ${{ number_format($d->precio_final, 2) }}
                            </td>
                            <td class="p-8 text-right font-mono text-green-400 text-3xl font-black italic">
                                ${{ number_format($d->subtotal, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection