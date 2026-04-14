@php
    $stockLocal = ($sucursalUsuario == 1) ? ($producto->stock_s1 ?? 0) : ($producto->stock_s2 ?? 0);
    $isAgotadoLocal = ($stockLocal <= 0);
    $urlImagen = !empty($producto->imagen) ? asset('imagenes/' . $producto->imagen) : null;
    $valorCambio = $tipoCambio ?? 6.96;
@endphp

<div class="bg-[#111419] rounded-[2.5rem] border border-gray-800/50 shadow-2xl hover:shadow-[0_20px_50px_rgba(16,185,129,0.2)] hover:border-custom-brand transition-all duration-500 overflow-hidden flex flex-col group relative {{ $isAgotadoLocal ? 'opacity-90' : '' }}">
    
    {{-- Botón Detalles (Info) --}}
    <button onclick="openModal({{ json_encode($producto) }})" class="absolute top-5 right-5 z-30 bg-white/10 hover:bg-custom-brand text-white hover:text-black p-2.5 rounded-full border border-white/10 transition-all duration-300 backdrop-blur-md shadow-xl">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </button>

    @if($isAgotadoLocal)
        <div class="absolute inset-0 z-20 flex items-center justify-center pointer-events-none">
            <span class="bg-red-600/90 text-white font-black text-xs px-6 py-2 rounded-full uppercase tracking-[0.3em] rotate-12 border-2 border-red-400/50 shadow-[0_0_20px_rgba(220,38,38,0.6)] backdrop-blur-sm">Agotado Local</span>
        </div>
    @endif

    {{-- Badge Categoría --}}
    <div class="absolute top-5 left-5 z-10">
        <span class="bg-black/90 backdrop-blur-md border border-white/20 text-custom-brand font-black text-[11px] px-4 py-2 rounded-xl uppercase tracking-widest shadow-2xl">
            // {{ $producto->tipo }}
        </span>
    </div>

    {{-- Contenedor de Imagen --}}
    <div 
        @if($urlImagen) onclick="openImageModal('{{ $urlImagen }}', '{{ $producto->codigo_interno }}')" @endif
        class="relative w-full h-64 overflow-hidden bg-[#1c2128] flex items-center justify-center {{ $urlImagen ? 'cursor-zoom-in group/img' : '' }}"
    >
        @if($urlImagen)
            <img src="{{ $urlImagen }}" class="w-full h-full object-contain p-6 transform group-hover:scale-110 transition-all duration-700 {{ $isAgotadoLocal ? 'opacity-40 grayscale-[0.5] blur-[0.5px]' : '' }}">
            <div class="absolute inset-0 bg-custom-brand/10 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center">
                <div class="bg-white/20 backdrop-blur-md p-3 rounded-full border border-white/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                    </svg>
                </div>
            </div>
        @else
            <div class="w-full h-full flex flex-col items-center justify-center text-gray-700 bg-gradient-to-b from-[#1c2128] to-[#111419]">
                <svg class="w-16 h-16 mb-2 opacity-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="text-[10px] font-black uppercase tracking-[0.4em] opacity-20 italic">Sin Imagen</span>
            </div>
        @endif
        <div class="absolute bottom-0 left-0 w-full h-1/4 bg-gradient-to-t from-[#111419] to-transparent"></div>
    </div>

    {{-- Cuerpo --}}
    <div class="p-6 flex flex-col flex-grow relative">
        <div class="flex justify-between items-center mb-4">
            <span class="bg-custom-brand/10 text-custom-brand text-[10px] font-black uppercase px-2.5 py-1 rounded-lg tracking-tighter border border-custom-brand/20">
                {{ $producto->marca_nombre }}
            </span>
            <span class="text-gray-500 text-[10px] font-mono font-bold tracking-widest">REF: {{ $producto->codigo_interno }}</span>
        </div>

        <h3 class="font-black text-gray-100 mb-5 line-clamp-2 h-12 text-lg leading-tight tracking-tighter group-hover:text-custom-brand transition-colors uppercase italic">
            {{ $producto->descripcion ?? 'Componente técnico' }}
        </h3>

        {{-- Precio --}}
        <div class="flex items-center gap-3 mb-6 bg-white/5 p-3 rounded-2xl border border-white/5 shadow-inner">
            <div class="flex flex-col">
                <span class="text-[9px] text-gray-400 font-bold uppercase leading-none mb-1">Precio Neto</span>
                <span class="text-2xl font-black text-white tracking-tighter">${{ number_format($producto->precio_lista_dolares, 2) }}</span>
            </div>
            <div class="h-8 w-px bg-gray-800 mx-1"></div>
            <span class="text-[10px] text-custom-brand font-black vertical-text uppercase tracking-widest">USD</span>
        </div>

        {{-- Stock --}}
        <div class="grid grid-cols-2 gap-3 mb-6">
            <div class="bg-black/40 border {{ ($sucursalUsuario == 1) ? 'border-custom-brand/50 bg-custom-brand/5' : 'border-gray-800' }} rounded-2xl p-3 text-center transition-all relative">
                @if($sucursalUsuario == 1)
                    <span class="absolute -top-2 left-1/2 -translate-x-1/2 bg-custom-brand text-black text-[7px] font-black px-2 py-0.5 rounded-full uppercase tracking-tighter shadow-lg">Tu Sede</span>
                @endif
                <p class="text-[9px] text-gray-500 font-black uppercase tracking-widest mb-1 italic">S. Central</p>
                <span class="text-2xl font-black {{ ($producto->stock_s1 > 0) ? 'text-white' : 'text-red-600/50' }}">{{ $producto->stock_s1 ?? 0 }}</span>
            </div>
            <div class="bg-black/40 border {{ ($sucursalUsuario == 2) ? 'border-custom-brand/50 bg-custom-brand/5' : 'border-gray-800' }} rounded-2xl p-3 text-center transition-all relative">
                @if($sucursalUsuario == 2)
                    <span class="absolute -top-2 left-1/2 -translate-x-1/2 bg-custom-brand text-black text-[7px] font-black px-2 py-0.5 rounded-full uppercase tracking-tighter shadow-lg">Tu Sede</span>
                @endif
                <p class="text-[9px] text-gray-500 font-black uppercase tracking-widest mb-1 italic">S. Norte</p>
                <span class="text-2xl font-black {{ ($producto->stock_s2 > 0) ? 'text-white' : 'text-red-600/50' }}">{{ $producto->stock_s2 ?? 0 }}</span>
            </div>
        </div>

        {{-- Botón Confirmar Venta --}}
        <div class="mt-auto">
            @if(!$isAgotadoLocal)
                <button onclick="openVentaModal({{ json_encode($producto) }}, {{ $stockLocal }}, {{ $valorCambio }})" class="w-full flex items-center justify-center gap-2 bg-white text-black font-black py-3.5 rounded-[1.2rem] hover:bg-custom-brand hover:text-white transition-all duration-300 shadow-xl active:scale-95 text-[12px] uppercase tracking-[0.1em] group/btn">
                    <span>Confirmar Venta</span>
                    <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            @else
                <button disabled class="w-full flex items-center justify-center gap-2 bg-gray-800/30 text-gray-600 font-black py-3.5 rounded-[1.2rem] cursor-not-allowed text-[12px] uppercase tracking-[0.1em] border border-gray-800">
                    <svg class="w-4 h-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                    <span>Sin Stock Local</span>
                </button>
            @endif
        </div>
    </div>
</div>