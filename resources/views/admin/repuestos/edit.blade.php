@extends('layouts.admin')

@section('admin_content')
<div class="max-w-4xl mx-auto bg-slate-900 p-8 rounded-3xl border border-slate-700 shadow-2xl">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-yellow-400 uppercase tracking-tight">
            Editar {{ ucfirst($tipo) }}: {{ $repuesto->codigo_interno }}
        </h2>
        <span class="bg-slate-800 text-slate-400 px-4 py-1 rounded-full text-xs font-mono">ID PM: #{{ $repuesto->pm_id }}</span>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-500/20 border border-red-500 text-red-200 rounded-xl text-sm">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.repuestos.update', [$tipo, $repuesto->pm_id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf 
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-800/40 p-6 rounded-2xl border border-slate-700">
            
            {{-- IMAGEN CON PREVISUALIZACIÓN --}}
            <div class="flex flex-col items-center justify-center border-r border-slate-700/50 pr-6">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-4 w-full text-center">Imagen del Producto</label>
                <div class="relative group mb-4">
                    <img id="preview" 
                         src="{{ $repuesto->imagen ? asset('imagenes/' . $repuesto->imagen) : '' }}" 
                         class="w-48 h-48 object-cover rounded-2xl border-2 border-slate-600 shadow-xl {{ !$repuesto->imagen ? 'hidden' : '' }}">
                    
                    <div id="placeholder" class="w-48 h-48 bg-slate-900 rounded-2xl flex items-center justify-center text-6xl border-2 border-dashed border-slate-700 {{ $repuesto->imagen ? 'hidden' : '' }}">
                        ⚙️
                    </div>
                </div>
                <input type="file" name="imagen" id="imagenInput" onchange="previewImage(event)" class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-yellow-500 file:text-black hover:file:bg-yellow-400 cursor-pointer">
                <p class="text-[10px] text-slate-500 mt-2">Formatos: JPG, PNG. Máx 2MB. Dejar vacío para mantener actual.</p>
            </div>

            {{-- DATOS GENERALES --}}
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Código Interno</label>
                    <input type="text" name="codigo_interno" value="{{ old('codigo_interno', $repuesto->codigo_interno) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-yellow-500 transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Marca</label>
                    <select name="marca_id" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-yellow-500">
                        @foreach($marcas as $m)
                            <option value="{{ $m->id }}" {{ old('marca_id', $repuesto->marca_id) == $m->id ? 'selected' : '' }}>
                                {{ $m->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Stock en Sucursal</label>
                    <input type="number" name="stock_actual" value="{{ old('stock_actual', $repuesto->stock_actual) }}" required class="w-full bg-slate-950 border border-blue-500/30 rounded-xl p-3 text-blue-400 font-black text-xl focus:border-blue-500">
                </div>
            </div>
        </div>

        {{-- PRECIO Y DESCRIPCIÓN --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Precio Lista ($)</label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-green-500">$</span>
                    <input type="number" step="0.01" name="precio_lista_dolares" value="{{ old('precio_lista_dolares', $repuesto->precio_lista_dolares) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 pl-8 text-green-400 font-mono text-lg focus:border-green-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Descripción / Notas</label>
                <textarea name="descripcion" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:border-yellow-500" rows="1">{{ old('descripcion', $repuesto->descripcion) }}</textarea>
            </div>
        </div>

        {{-- ESPECIFICACIONES --}}
        <div class="bg-slate-800/60 p-6 rounded-2xl border border-slate-700">
            <h3 class="text-xs font-black text-slate-400 uppercase mb-4 tracking-widest border-b border-slate-700 pb-2">
                Especificaciones Técnicas del {{ ucfirst($tipo) }}
            </h3>
            
            @if($tipo == 'bendix')
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Cod. ZEN</label>
                        <input type="text" name="codigo_zen" value="{{ old('codigo_zen', $repuesto->codigo_zen) }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Dientes</label>
                        <input type="number" name="dientes" value="{{ old('dientes', $repuesto->dientes) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Estrías</label>
                        <input type="number" name="estrias" value="{{ old('estrias', $repuesto->estrias) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Sentido</label>
                        <select name="sentido" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                            <option value="horario" {{ old('sentido', $repuesto->sentido) == 'horario' ? 'selected' : '' }}>Horario</option>
                            <option value="antihorario" {{ old('sentido', $repuesto->sentido) == 'antihorario' ? 'selected' : '' }}>Antihorario</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Ø Externo (mm)</label>
                        <input type="number" step="0.01" name="diametro_externo" value="{{ old('diametro_externo', $repuesto->diametro_externo) }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Ø Interno (mm)</label>
                        <input type="number" step="0.01" name="diametro_interno" value="{{ old('diametro_interno', $repuesto->diametro_interno) }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Largo (mm)</label>
                        <input type="number" step="0.01" name="largo" value="{{ old('largo', $repuesto->largo) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                </div>

            @elseif($tipo == 'inducido')
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Voltaje (V)</label>
                        <input type="number" name="voltaje" value="{{ old('voltaje', $repuesto->voltaje) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Largo (mm)</label>
                        <input type="number" step="0.01" name="largo" value="{{ old('largo', $repuesto->largo) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Ø Externo (mm)</label>
                        <input type="number" step="0.01" name="diametro_externo" value="{{ old('diametro_externo', $repuesto->diametro_externo) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Estrías</label>
                        <input type="number" name="estrias" value="{{ old('estrias', $repuesto->estrias) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Delgas</label>
                        <input type="number" name="delgas" value="{{ old('delgas', $repuesto->delgas) }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Cod. Original</label>
                        <input type="text" name="codigo_original" value="{{ old('codigo_original', $repuesto->codigo_original) }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                </div>

            @elseif($tipo == 'regulador')
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Sistema</label>
                        <input type="text" name="sistema" value="{{ old('sistema', $repuesto->sistema) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Voltaje (V)</label>
                        <input type="number" name="voltaje" value="{{ old('voltaje', $repuesto->voltaje) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Terminales</label>
                        <input type="text" name="terminales" value="{{ old('terminales', $repuesto->terminales) }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-500 uppercase font-bold">Circuito</label>
                        <input type="text" name="circuito" value="{{ old('circuito', $repuesto->circuito) }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white">
                    </div>
                    <div class="flex items-center gap-3 pt-5">
                        <input type="checkbox" name="capacitor" value="1" id="cap" class="w-5 h-5 rounded border-slate-700 bg-slate-900 text-yellow-500 focus:ring-yellow-500" {{ old('capacitor', $repuesto->capacitor) ? 'checked' : '' }}>
                        <label for="cap" class="text-xs text-slate-400 uppercase font-bold cursor-pointer">¿Capacitor?</label>
                    </div>
                </div>
            @endif
        </div>

        {{-- BOTONES LIMPIOS SIN ICONOS --}}
        <div class="flex flex-col md:flex-row gap-4 pt-4">
            <button type="submit" class="flex-1 bg-yellow-500 text-black font-black py-4 rounded-2xl uppercase hover:bg-yellow-400 transition-all shadow-lg shadow-yellow-500/20">
                Guardar Cambios
            </button>
            
            <a href="{{ route('admin.repuestos.index', $tipo) }}" class="flex-1 bg-slate-800 text-white font-black py-4 rounded-2xl uppercase hover:bg-slate-700 transition-all text-center flex items-center justify-center">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');
        
        reader.onload = function() {
            preview.src = reader.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
        
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection