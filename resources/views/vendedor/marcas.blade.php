@extends('layouts.app') {{-- Usando tu layout principal --}}

@section('content')
<div class="min-h-screen bg-[#0f1115] py-12 px-6 selection:bg-custom-brand selection:text-black">
    <div class="max-w-[1400px] mx-auto">
        
        {{-- Encabezado de la sección con estilo Glassmorphism --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#161920] to-[#0f1115] border border-gray-800 p-8 md:p-12 mb-12 shadow-2xl">
            {{-- Decoración de fondo --}}
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-custom-brand/10 rounded-full blur-[120px]"></div>
            <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-blue-500/5 rounded-full blur-[100px]"></div>

            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        {{-- Texto ajustado a la realidad del negocio --}}
                        <span class="px-3 py-1 bg-custom-brand/10 border border-custom-brand/20 rounded-full text-custom-brand text-[10px] font-black uppercase tracking-[0.2em]">Stock Disponible</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black text-white tracking-tighter uppercase leading-none">
                        Nuestras <span class="text-transparent bg-clip-text bg-gradient-to-r from-custom-brand to-emerald-400">Marcas</span>
                    </h1>
                    {{-- Texto más directo para el vendedor --}}
                    <p class="text-gray-400 font-medium text-lg max-w-xl">
                        Selecciona un fabricante para filtrar rápidamente los repuestos y consultar disponibilidad de piezas.
                    </p>
                </div>

                <div class="flex flex-col items-end gap-3">
                    <div class="bg-black/40 backdrop-blur-md px-6 py-4 rounded-2xl border border-gray-700/50 shadow-inner flex items-center gap-4">
                        <div class="text-right">
                            <span class="block text-3xl font-black text-white leading-none">{{ $marcas->count() }}</span>
                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Registradas</span>
                        </div>
                        <div class="h-10 w-10 bg-custom-brand rounded-xl flex items-center justify-center shadow-[0_0_20px_rgba(16,185,129,0.3)]">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid de Marcas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($marcas as $marca)
                <a href="{{ route('vendedor.catalogo', ['marcas[]' => $marca->id]) }}" 
                   class="group relative bg-[#161920] border border-gray-800/50 rounded-[2rem] p-8 transition-all duration-500 hover:border-custom-brand/50 hover:shadow-[0_20px_50px_rgba(0,0,0,0.5)] hover:-translate-y-2 overflow-hidden">
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-custom-brand/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-8">
                            <div class="h-20 w-20 bg-gray-900 rounded-2xl flex items-center justify-center text-4xl font-black text-custom-brand border border-gray-800 shadow-2xl group-hover:scale-110 group-hover:bg-custom-brand group-hover:text-black transition-all duration-500 group-hover:rotate-3">
                                {{ substr($marca->nombre, 0, 1) }}
                            </div>

                            <div class="bg-gray-900/80 px-3 py-1.5 rounded-full border border-gray-800 group-hover:border-custom-brand/30 transition-colors">
                                <span class="text-[10px] font-black text-gray-500 group-hover:text-custom-brand uppercase tracking-widest leading-none">
                                    {{ $marca->total_productos }} Items
                                </span>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <h3 class="text-2xl font-black text-white group-hover:text-custom-brand transition-colors uppercase tracking-tighter">
                                {{ $marca->nombre }}
                            </h3>
                            <p class="text-gray-500 text-sm font-medium">Línea de repuestos técnicos</p>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-800 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-gray-600 uppercase tracking-[0.2em] group-hover:text-gray-400 transition-colors">Ver Inventario</span>
                            <div class="h-10 w-10 rounded-full flex items-center justify-center bg-gray-900 border border-gray-800 text-gray-400 group-hover:bg-custom-brand group-hover:text-black group-hover:border-custom-brand transition-all duration-500 group-hover:translate-x-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection