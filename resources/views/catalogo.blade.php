@extends('layouts.app')

@section('title', 'Catálogo Real | ROMARTEX')

@section('content')
    {{-- Notificaciones removidas de aquí para usar Modales --}}

    {{-- Encabezado --}}
    <div class="mb-10 p-8 rounded-[2rem] bg-gradient-to-r from-[#111419] to-[#1a1f26] border border-gray-800 shadow-2xl flex flex-col md:flex-row md:items-end md:justify-between gap-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-custom-brand/5 rounded-full blur-[100px] -mr-32 -mt-32"></div>
        <div class="relative z-10">
            <h1 class="text-5xl md:text-6xl font-black text-white tracking-tighter uppercase italic leading-none mb-3">
                Catálogo de <span class="text-custom-brand drop-shadow-[0_0_15px_rgba(16,185,129,0.3)]">Autopartes</span>
            </h1>
            <p class="text-gray-400 font-bold flex items-center gap-3 uppercase text-sm tracking-widest">
                <span class="flex h-3 w-3 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-custom-brand opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-custom-brand"></span>
                </span>
                Stock en tiempo real: <span class="text-white bg-white/10 px-3 py-0.5 rounded-lg border border-white/10">{{ count($productos) }} ítems en esta sucursal</span>
            </p>
        </div>
        <div class="relative z-10 flex flex-col items-start md:items-end gap-2">
            {{-- Mejora: Identificador de Sucursal Dinámico --}}
            <span class="text-[11px] font-black text-custom-brand uppercase tracking-[0.4em] opacity-80">
                Terminal de Inventario: Nodo-0{{ auth()->user()->sucursal_id }}
            </span>
            <div class="h-1.5 w-48 bg-gray-900 rounded-full border border-gray-800 overflow-hidden shadow-inner">
                <div class="h-full bg-gradient-to-r from-custom-brand to-green-400 w-3/4 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
            </div>
            {{-- Mejora: Status con referencia a la sucursal actual --}}
            <span class="text-[10px] text-gray-500 font-mono italic">
                Status: Online // Sucursal_{{ auth()->user()->sucursal_id == 1 ? 'CENTRAL' : 'NORTE' }} // v2.6
            </span>
        </div>
    </div>

    {{-- Grid de Productos --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($productos as $producto)
            @include('vendedor._card_producto')
        @empty
            <div class="col-span-full py-32 text-center bg-[#111419] rounded-[3rem] border border-dashed border-gray-800">
                <h3 class="text-3xl font-black text-gray-600 uppercase italic tracking-tighter">Sin productos vinculados</h3>
                <p class="text-gray-500 mt-2 font-bold uppercase text-xs tracking-widest">
                    Solo se muestran productos registrados por el administrador de esta sucursal.
                </p>
            </div>
        @endforelse
    </div>

    {{-- Fragmentos de Modales y Scripts --}}
    @include('vendedor._modales_catalogo')
    @include('vendedor._scripts_catalogo')

    {{-- CDN de SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection