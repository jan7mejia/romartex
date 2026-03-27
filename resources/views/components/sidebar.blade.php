<aside class="w-80 flex-shrink-0 bg-custom-header text-white p-8 rounded-3xl self-start shadow-xl border border-gray-800">
    <div class="flex items-center justify-between mb-10 pb-4 border-b border-gray-800">
        <h2 class="text-2xl font-bold text-gray-100">Filtros</h2>
        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
    </div>

    {{-- Bloque Catálogos Colapsable --}}
    <details class="mb-9 group" open>
        <summary class="flex items-center justify-between w-full text-left group cursor-pointer mb-5 outline-none">
            <span class="font-semibold text-xl text-gray-100 group-hover:text-custom-brand">Catálogos</span>
            <svg class="w-6 h-6 text-gray-500 group-hover:text-custom-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </summary>

        <div class="space-y-4 pl-1 text-gray-300 pb-1">
            <label class="flex items-center gap-3.5 cursor-pointer hover:text-white">
                <input type="checkbox" checked class="form-checkbox h-5 w-5 rounded border-gray-700 bg-gray-800 text-custom-brand">
                Inducidos
            </label>
            <label class="flex items-center gap-3.5 cursor-pointer hover:text-white">
                <input type="checkbox" class="form-checkbox h-5 w-5 rounded border-gray-700 bg-gray-800 text-custom-brand">
                Bendex
            </label>
            <label class="flex items-center gap-3.5 cursor-pointer hover:text-white">
                <input type="checkbox" class="form-checkbox h-5 w-5 rounded border-gray-700 bg-gray-800 text-custom-brand">
                Reguladores
            </label>
        </div>
    </details>

    {{-- Bloque Marcas Colapsable --}}
    <details class="mb-9 group" open>
        <summary class="flex items-center justify-between w-full text-left group cursor-pointer mb-5 outline-none">
            <span class="font-semibold text-xl text-gray-100 group-hover:text-custom-brand">Marcas</span>
            <svg class="w-6 h-6 text-gray-500 group-hover:text-custom-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </summary>

        <div class="space-y-4 pl-1 text-gray-300 pb-1">
            <label class="flex items-center gap-3.5 cursor-pointer hover:text-white">
                <input type="checkbox" class="form-checkbox h-5 w-5 rounded border-gray-700 bg-gray-800 text-custom-brand">
                Bosch
            </label>
            <label class="flex items-center gap-3.5 cursor-pointer hover:text-white">
                <input type="checkbox" class="form-checkbox h-5 w-5 rounded border-gray-700 bg-gray-800 text-custom-brand">
                Delco
            </label>
            <label class="flex items-center gap-3.5 cursor-pointer hover:text-white">
                <input type="checkbox" class="form-checkbox h-5 w-5 rounded border-gray-700 bg-gray-800 text-custom-brand">
                Denso
            </label>
            <label class="flex items-center gap-3.5 cursor-pointer hover:text-white">
                <input type="checkbox" class="form-checkbox h-5 w-5 rounded border-gray-700 bg-gray-800 text-custom-brand">
                Nippondenso
            </label>
        </div>
    </details>

    {{-- Botón Limpiar --}}
    <button class="w-full bg-custom-brand text-black font-extrabold py-4 px-6 rounded-2xl hover:bg-green-400 transition transform hover:-translate-y-0.5 active:translate-y-0 shadow-lg mt-10">
        Limpiar Filtros
    </button>
</aside>