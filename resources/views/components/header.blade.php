<header class="bg-[#0f1115] text-white shadow-2xl sticky top-0 z-50 w-full border-b border-gray-800">
    <nav class="max-w-[1600px] mx-auto px-6 py-4 flex items-center justify-between gap-10">
        
        <a href="{{ route('vendedor.catalogo') }}" class="flex items-center gap-3 flex-shrink-0 group">
            <div class="h-11 w-11 bg-custom-brand rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(16,185,129,0.4)] group-hover:rotate-6 transition-transform">
                <svg class="w-7 h-7 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="font-black text-2xl tracking-tighter uppercase leading-none text-white">ROMARTEX</span>
                <span class="text-[10px] text-custom-brand font-bold tracking-[0.2em] uppercase leading-none">TIENDA</span>
            </div>
        </a>

        {{-- Formulario de Búsqueda --}}
        <form action="{{ route('vendedor.catalogo') }}" method="GET" id="search-form" class="relative flex-grow max-w-3xl group">
            <style>
                input[type="search"]::-webkit-search-decoration,
                input[type="search"]::-webkit-search-cancel-button,
                input[type="search"]::-webkit-search-results-button,
                input[type="search"]::-webkit-search-results-decoration {
                    display: none;
                }
            </style>
            <input type="search" 
                id="search-input"
                name="search"
                autocomplete="off"
                placeholder="¿Qué pieza técnica buscas hoy? (Nombre, marca o código...)" 
                class="w-full pl-7 pr-24 py-3.5 rounded-2xl border-none bg-white text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-custom-brand transition-all duration-300 text-base shadow-lg font-medium">
            
            <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1">
                {{-- Botón X (Mejorado: No recarga la página) --}}
                <button type="button" 
                    id="clear-search" 
                    class="hidden p-2 rounded-full hover:bg-gray-100 text-gray-400 hover:text-red-500 transition-all flex items-center justify-center"
                    title="Limpiar texto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Botón Lupa --}}
                <button type="submit" class="p-2 text-gray-400 group-focus-within:text-custom-brand transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </div>
        </form>

        <div class="flex items-center gap-6 flex-shrink-0">
            <div class="hidden md:flex flex-col text-right border-r border-gray-700 pr-6">
                <span class="text-[10px] font-bold text-custom-brand uppercase tracking-widest">Vendedor Activo</span>
                <span class="text-sm font-bold text-gray-100">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</span>
                <div class="flex items-center justify-end gap-1.5 mt-0.5">
                    <span class="flex h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-[11px] text-gray-400 font-medium">Sucursal: <span class="text-gray-200">{{ Auth::user()->sucursal->nombre ?? 'N/A' }}</span></span>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center justify-center p-3 rounded-2xl bg-gray-800 hover:bg-red-500/10 hover:text-red-500 transition-all group border border-transparent hover:border-red-500/50 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </nav>

    <div class="bg-[#050505] border-t border-gray-800/50 py-3">
        <div class="max-w-[1600px] mx-auto px-6 flex items-center justify-between">
            <div class="flex items-center gap-12 text-lg">
                <a href="{{ route('vendedor.catalogo') }}" class="font-bold flex items-center gap-2 text-white hover:text-custom-brand transition-colors duration-300 uppercase">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                    CATEGORÍAS
                </a>
                <a href="{{ route('vendedor.marcas') }}" class="font-bold flex items-center gap-2 text-white hover:text-custom-brand transition-colors duration-300 uppercase">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    MARCAS
                </a>
            </div>

            <div class="hidden lg:flex items-center gap-8">
                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-black text-gray-500 uppercase tracking-tighter">Tipo de Cambio:</span>
                    <span id="exchange-rate" class="text-sm font-bold text-green-400 text-shadow-glow">
                        Bs. {{ number_format($tipoCambio ?? 6.96, 2) }}
                    </span>
                </div>
                <div class="text-[11px] text-gray-500 font-bold uppercase italic">
                    <span id="current-date"></span>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // 1. Script para la Fecha
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const dateEl = document.getElementById('current-date');
    if(dateEl) dateEl.textContent = new Date().toLocaleDateString('es-ES', options);

    // 2. Lógica del Buscador sin recarga
    const searchInput = document.getElementById('search-input');
    const clearBtn = document.getElementById('clear-search');

    // Escuchar cuando el usuario escribe
    searchInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }
    });

    // Acción de la "X": Limpiar sin recargar
    clearBtn.addEventListener('click', function() {
        searchInput.value = ''; // Borra el texto
        this.classList.add('hidden'); // Oculta la X
        searchInput.focus(); // Devuelve el cursor al buscador para que el usuario siga trabajando
    });
</script>