@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto bg-slate-900 p-8 rounded-3xl border border-slate-700 shadow-2xl">
    <h2 class="text-2xl font-bold mb-6 text-green-400 uppercase tracking-tight">Nuevo {{ ucfirst($tipo) }}</h2>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500 rounded-2xl">
            <ul class="list-disc list-inside text-red-500 text-sm font-bold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.repuestos.store', $tipo) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-800/40 p-6 rounded-2xl border border-slate-700">
            <div class="flex flex-col items-center justify-center space-y-4">
                <label class="block text-xs font-bold text-slate-500 uppercase w-full text-left">Imagen del Repuesto</label>
                
                <div class="relative w-full h-48 bg-slate-900 rounded-2xl border-2 border-dashed border-slate-700 flex items-center justify-center overflow-hidden">
                    <img id="preview" src="#" alt="Vista previa" class="hidden absolute inset-0 w-full h-full object-contain p-2">
                    
                    <div id="placeholder-text" class="text-slate-600 text-center flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-[10px] font-bold uppercase">Sin imagen seleccionada</span>
                    </div>
                </div>

                <input type="file" name="imagen" id="imagen_input" accept="image/*" class="w-full text-xs text-white bg-slate-900 p-2 rounded-lg border border-slate-700 file:bg-slate-700 file:text-white file:border-none file:rounded-md file:px-4 file:py-1 file:mr-4 file:hover:bg-slate-600 cursor-pointer">
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase">Código Interno</label>
                    <input type="text" name="codigo_interno" value="{{ old('codigo_interno') }}" required class="w-full bg-slate-900 border @error('codigo_interno') border-red-500 @else border-slate-700 @enderror rounded-xl p-2 text-white focus:border-green-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase">Marca</label>
                    <select name="marca_id" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-2 text-white focus:border-green-500 outline-none">
                        <option value="" disabled {{ old('marca_id') ? '' : 'selected' }}>-- Seleccione la marca --</option>
                        @foreach($marcas as $m)
                            <option value="{{ $m->id }}" {{ old('marca_id') == $m->id ? 'selected' : '' }}>{{ $m->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase">Precio Lista ($)</label>
                <input type="number" step="0.01" name="precio_lista_dolares" value="{{ old('precio_lista_dolares') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-2 text-green-400 font-mono focus:border-green-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-yellow-500 uppercase">Stock Inicial</label>
                <input type="number" name="stock_inicial" value="{{ old('stock_inicial', 0) }}" min="0" required class="w-full bg-slate-900 border border-yellow-500/50 rounded-xl p-2 text-white font-mono focus:border-yellow-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase">Descripción Corta</label>
                <textarea name="descripcion" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-2 text-white focus:border-green-500 outline-none" rows="1">{{ old('descripcion') }}</textarea>
            </div>
        </div>

        <div class="bg-slate-800/60 p-6 rounded-2xl border border-slate-700">
            <h3 class="text-xs font-black text-slate-400 uppercase mb-4 tracking-widest">Especificaciones Técnicas Completas</h3>

            @if($tipo == 'bendix')
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div><label class="text-[10px] text-slate-500 uppercase">Código ZEN</label><input type="text" name="codigo_zen" value="{{ old('codigo_zen') }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Dientes</label><input type="number" name="dientes" value="{{ old('dientes') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Estrías</label><input type="number" name="estrias" value="{{ old('estrias') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase">Sentido</label>
                        <select name="sentido" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                            <option value="" disabled {{ old('sentido') ? '' : 'selected' }}>-- Seleccione el sentido --</option>
                            <option value="horario" {{ old('sentido') == 'horario' ? 'selected' : '' }}>Horario</option>
                            <option value="antihorario" {{ old('sentido') == 'antihorario' ? 'selected' : '' }}>Antihorario</option>
                        </select>
                    </div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Ø Externo (mm)</label><input type="number" step="0.01" name="diametro_externo" value="{{ old('diametro_externo') }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Ø Interno (mm)</label><input type="number" step="0.01" name="diametro_interno" value="{{ old('diametro_interno') }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Largo (mm)</label><input type="number" step="0.01" name="largo" value="{{ old('largo') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                </div>
            @elseif($tipo == 'inducido')
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div><label class="text-[10px] text-slate-500 uppercase">Voltaje (V)</label><input type="number" name="voltaje" value="{{ old('voltaje') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Largo (mm)</label><input type="number" step="0.01" name="largo" value="{{ old('largo') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Ø Externo</label><input type="number" step="0.01" name="diametro_externo" value="{{ old('diametro_externo') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Estrías</label><input type="number" name="estrias" value="{{ old('estrias') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Delgas</label><input type="number" name="delgas" value="{{ old('delgas') }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Cod. Original</label><input type="text" name="codigo_original" value="{{ old('codigo_original') }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                </div>
            @elseif($tipo == 'regulador')
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-[10px] text-slate-500 uppercase">Sistema</label><input type="text" name="sistema" value="{{ old('sistema') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Voltaje</label><input type="number" name="voltaje" value="{{ old('voltaje') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Terminales</label><input type="number" name="terminales" value="{{ old('terminales') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div><label class="text-[10px] text-slate-500 uppercase">Circuito</label><input type="text" name="circuito" value="{{ old('circuito') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white"></div>
                    <div class="flex items-center space-x-2 pt-6">
                        <input type="checkbox" name="capacitor" value="1" {{ old('capacitor') ? 'checked' : '' }} class="w-5 h-5 accent-green-500">
                        <label class="text-xs text-slate-500 uppercase font-bold">Lleva Capacitor</label>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex flex-col md:flex-row gap-4 pt-4 border-t border-slate-800">
            <button type="submit" class="flex-1 bg-green-500 text-black font-black py-4 rounded-2xl uppercase hover:bg-green-400 transition-all shadow-lg shadow-green-500/20">
                Registrar {{ ucfirst($tipo) }} y Stock
            </button>

            <a href="{{ route('admin.repuestos.index', $tipo) }}" class="flex-1 bg-slate-800 text-white font-black py-4 rounded-2xl uppercase hover:bg-slate-700 transition-all text-center flex items-center justify-center border border-slate-700">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    document.getElementById('imagen_input').onchange = function (evt) {
        const [file] = this.files;
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder-text');
        
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        } else {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }
</script>
@endsection