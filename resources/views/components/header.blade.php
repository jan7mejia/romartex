<header class="bg-custom-header text-white shadow-lg sticky top-0 z-50 w-full">
    {{-- Barra Superior Principal (Ancho fluido w-[95%]) --}}
    <nav class="w-[95%] mx-auto py-4 flex items-center justify-between gap-12">
        {{-- Logo - Izquierda --}}
        <div class="flex items-center gap-3 flex-shrink-0">
            <img src="https://via.placeholder.com/40x40/32CD32/FFFFFF?text=L" alt="Logo" class="h-10 w-10 rounded">
            <span class="font-bold text-2xl tracking-tight uppercase">LARAVEL PARTS</span>
        </div>

        {{-- Buscador Central - Fondo Blanco y Ancho Expandido --}}
        <div class="relative flex-grow max-w-5xl">
            <input type="search" placeholder="Buscar autopartes por nombre, marca o categoría..." class="w-full px-6 py-3.5 pr-14 rounded-full border border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-custom-brand focus:border-custom-brand transition shadow-inner text-lg">
            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
        </div>

        {{-- Iconos/Acciones Derecha - Cambio a Cerrar Sesión --}}
        <div class="flex items-center gap-8 text-base flex-shrink-0">
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center gap-3 hover:text-red-500 transition group">
                    <div class="bg-gray-800 p-2.5 rounded-full group-hover:bg-red-900/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <span class="font-medium text-lg">Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </nav>

    {{-- Barra de Navegación Inferior (Negra) (Ancho fluido w-[95%]) --}}
    <div class="bg-black border-t border-gray-800 text-base">
        <div class="w-[95%] mx-auto py-3 flex items-center gap-10 text-lg">
            <a href="#" class="font-semibold text-white hover:text-custom-brand">Categorías</a>
            <a href="#" class="text-gray-300 hover:text-custom-brand">Marcas</a>
        </div>
    </div>
</header>