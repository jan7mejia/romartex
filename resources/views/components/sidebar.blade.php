<aside class="w-full bg-custom-header text-white p-6 rounded-3xl shadow-xl border border-gray-800">
    <form action="{{ route('vendedor.catalogo') }}" method="GET" id="searchForm">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-800">
            <h2 class="text-2xl font-bold text-gray-100">Búsqueda Técnica</h2>
            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>

        {{-- PASO 1: SELECCIONAR CATEGORÍA --}}
        <div id="step-1" class="{{ request('tipo') ? 'hidden' : '' }} mb-6">
            <span class="block text-xs font-bold text-custom-brand uppercase tracking-widest mb-4">1. Seleccione Categoría</span>
            <div class="grid grid-cols-1 gap-3">
                <label class="cursor-pointer group">
                    {{-- Mejora: Al hacer clic envía el formulario automáticamente --}}
                    <input type="radio" name="tipo" value="bendix" class="hidden peer" onchange="this.form.submit()" {{ request('tipo') == 'bendix' ? 'checked' : '' }}>
                    <div class="p-5 rounded-xl bg-gray-800 border-2 border-transparent hover:bg-gray-700 transition peer-checked:border-custom-brand">
                        <span class="text-base font-bold">Bendix</span>
                    </div>
                </label>
                <label class="cursor-pointer group">
                    <input type="radio" name="tipo" value="inducido" class="hidden peer" onchange="this.form.submit()" {{ request('tipo') == 'inducido' ? 'checked' : '' }}>
                    <div class="p-5 rounded-xl bg-gray-800 border-2 border-transparent hover:bg-gray-700 transition peer-checked:border-custom-brand">
                        <span class="text-base font-bold">Inducidos</span>
                    </div>
                </label>
                <label class="cursor-pointer group">
                    <input type="radio" name="tipo" value="regulador" class="hidden peer" onchange="this.form.submit()" {{ request('tipo') == 'regulador' ? 'checked' : '' }}>
                    <div class="p-5 rounded-xl bg-gray-800 border-2 border-transparent hover:bg-gray-700 transition peer-checked:border-custom-brand">
                        <span class="text-base font-bold">Reguladores</span>
                    </div>
                </label>
            </div>
        </div>

        {{-- SEGUNDA PARTE: SE MUESTRA SOLO AL SELECCIONAR --}}
        <div id="step-2" class="{{ request('tipo') ? '' : 'hidden' }}">
            
            {{-- Botón para volver a cambiar categoría --}}
            <button type="button" onclick="resetCategory()" class="mb-5 text-xs text-custom-brand uppercase font-black flex items-center gap-2 hover:text-green-400 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Cambiar Categoría
            </button>

            {{-- CAMPOS TÉCNICOS DINÁMICOS --}}
            <div id="tech-filters" class="mb-8">
                <span class="block text-xs font-bold text-custom-brand uppercase tracking-widest mb-4">Medidas de la Muestra</span>
                
                {{-- Filtros Bendix --}}
                <div id="fields-bendix" class="category-fields {{ request('tipo') == 'bendix' ? '' : 'hidden' }} space-y-4">
                    <input type="number" name="dientes" value="{{ request('dientes') }}" placeholder="Nº Dientes" class="w-full bg-gray-800 border-none rounded-xl p-4 text-base outline-none focus:ring-2 focus:ring-custom-brand">
                    <input type="number" name="estrias" value="{{ request('estrias') }}" placeholder="Nº Estrías" class="w-full bg-gray-800 border-none rounded-xl p-4 text-base outline-none focus:ring-2 focus:ring-custom-brand">
                    <input type="number" step="0.1" name="largo" value="{{ request('largo') }}" placeholder="Largo Total (mm)" class="w-full bg-gray-800 border-none rounded-xl p-4 text-base outline-none focus:ring-2 focus:ring-custom-brand">
                </div>

                {{-- Filtros Inducido --}}
                <div id="fields-inducido" class="category-fields {{ request('tipo') == 'inducido' ? '' : 'hidden' }} space-y-4">
                    <input type="text" name="sistema_i" value="{{ request('sistema_i') }}" placeholder="Sistema (Ej: Denso, Toyota...)" class="w-full bg-gray-800 border-none rounded-xl p-4 text-base outline-none focus:ring-2 focus:ring-custom-brand">
                    <input type="number" name="voltaje" value="{{ request('voltaje') }}" placeholder="Voltaje (12, 24, etc.)" class="w-full bg-gray-800 border-none rounded-xl p-4 text-base outline-none focus:ring-2 focus:ring-custom-brand">
                    <input type="number" step="0.1" name="diametro" value="{{ request('diametro') }}" placeholder="Ø Externo (Cuerpo)" class="w-full bg-gray-800 border-none rounded-xl p-4 text-base outline-none focus:ring-2 focus:ring-custom-brand">
                    <input type="number" name="estrias_i" value="{{ request('estrias_i') }}" placeholder="Nº Estrías" class="w-full bg-gray-800 border-none rounded-xl p-4 text-base outline-none focus:ring-2 focus:ring-custom-brand">
                </div>

                {{-- Filtros Regulador --}}
                <div id="fields-regulador" class="category-fields {{ request('tipo') == 'regulador' ? '' : 'hidden' }} space-y-4">
                    <input type="text" name="sistema" value="{{ request('sistema') }}" placeholder="Sistema (Denso, Bosch...)" class="w-full bg-gray-800 border-none rounded-xl p-4 text-base outline-none focus:ring-2 focus:ring-custom-brand">
                    <input type="number" name="voltaje_r" value="{{ request('voltaje_r') }}" placeholder="Voltaje" class="w-full bg-gray-800 border-none rounded-xl p-4 text-base outline-none focus:ring-2 focus:ring-custom-brand">
                    <input type="text" name="circuito" value="{{ request('circuito') }}" placeholder="Circuito (PD, LS, LI...)" class="w-full bg-gray-800 border-none rounded-xl p-4 text-base outline-none focus:ring-2 focus:ring-custom-brand">
                    <select name="capacitor" class="w-full bg-gray-800 border-none rounded-xl p-4 text-base text-gray-300 outline-none focus:ring-2 focus:ring-custom-brand">
                        <option value="">¿Tiene Capacitor?</option>
                        <option value="1" {{ request('capacitor') == '1' ? 'selected' : '' }}>Si</option>
                        <option value="0" {{ request('capacitor') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>

            {{-- MARCAS --}}
            <div class="mb-8">
                <span class="block text-xs font-bold text-custom-brand uppercase tracking-widest mb-4">Marcas Disponibles</span>
                <div class="grid grid-cols-2 gap-3 text-gray-300 max-h-56 overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($marcas as $marca)
                    <label class="flex items-center gap-3 p-3 rounded-lg bg-gray-800/50 cursor-pointer hover:bg-gray-700 transition">
                        <input type="checkbox" name="marcas[]" value="{{ $marca->id }}" {{ is_array(request('marcas')) && in_array($marca->id, request('marcas')) ? 'checked' : '' }} class="form-checkbox h-5 w-5 rounded border-gray-700 bg-gray-800 text-custom-brand">
                        <span class="text-sm font-medium truncate">{{ $marca->nombre }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full bg-custom-brand text-black font-black py-4 px-6 rounded-2xl hover:bg-green-400 transition shadow-lg transform active:scale-95 text-base uppercase tracking-wider">
                BUSCAR PRODUCTO
            </button>

            <a href="{{ route('vendedor.catalogo') }}" class="block text-center mt-8 text-xs font-black text-gray-500 hover:text-white transition uppercase tracking-[0.2em]">
                Limpiar todos los filtros
            </a>
        </div>
    </form>
</aside>

<script>
    function resetCategory() {
        // Redirigir a la URL limpia sin parámetros para resetear todo
        window.location.href = "{{ route('vendedor.catalogo') }}";
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #111827;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #10b981;
        border-radius: 10px;
    }
</style>