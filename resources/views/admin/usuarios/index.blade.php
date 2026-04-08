@extends('layouts.admin')

@section('admin_content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
    <div>
        <h2 class="text-5xl font-black capitalize text-white tracking-tight">Vendedores</h2>
        <p class="text-slate-300 font-medium text-xl mt-2">Personal de Sucursal: <span class="text-green-400">{{ auth()->user()->sucursal->nombre ?? 'Mi Sucursal' }}</span></p>
    </div>

    <div class="flex flex-col md:flex-row gap-4 items-end">
        {{-- Buscador en Tiempo Real --}}
        <div class="relative w-full md:w-80">
            <input type="text" id="filtroNombre" placeholder="🔍 Buscar vendedor..." 
                class="w-full bg-slate-800 border border-slate-700 text-white rounded-2xl px-5 py-3 focus:border-blue-500 outline-none shadow-inner font-bold">
        </div>

        <div class="flex gap-4">
            <a href="{{ route('admin.dashboard') }}" class="bg-slate-800 text-white px-6 py-3 rounded-2xl font-bold hover:bg-slate-700 transition border border-slate-700 shadow-lg flex items-center gap-2 text-lg">
                ⬅ Volver
            </a>

            <a href="{{ route('admin.usuarios.create') }}" class="bg-green-500 text-black px-6 py-3 rounded-2xl font-black hover:bg-green-400 transition shadow-lg shadow-green-500/20 uppercase tracking-wider text-lg">
                + Nuevo Vendedor
            </a>
        </div>
    </div>
</div>

{{-- EL MENSAJE DE ÉXITO SE ELIMINÓ DE AQUÍ PORQUE YA ESTÁ EN EL LAYOUT PADRE --}}

<div class="bg-slate-900 rounded-[2rem] border border-slate-800 overflow-hidden shadow-2xl">
    <table class="w-full text-left border-collapse" id="tablaUsuarios">
        <thead class="bg-slate-950 text-slate-400 text-sm uppercase tracking-wider border-b border-slate-800">
            <tr>
                <th class="p-6">Perfil</th>
                <th class="p-6">Información del Vendedor</th>
                <th class="p-6">Contacto Directo</th>
                <th class="p-6">Acceso (Email)</th>
                <th class="p-6 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800/50">
        @forelse($usuarios as $user)
        <tr class="hover:bg-blue-500/[0.05] transition-all group fila-usuario">
            <td class="p-6">
                <div class="w-20 h-20 bg-slate-800 rounded-2xl flex items-center justify-center text-4xl border-2 border-slate-700 group-hover:border-green-500 transition-all">
                    👤
                </div>
            </td>
            <td class="p-6">
                <div class="flex flex-col gap-1">
                    <span class="text-xs text-slate-500 font-mono uppercase tracking-tighter">ID: #{{ $user->id }}</span>
                    <span class="text-white font-black text-2xl tracking-tight nombre-usuario-texto">
                        {{ $user->nombre }} {{ $user->apellido }}
                    </span>
                    <span class="bg-green-500/10 border border-green-500/20 text-green-400 px-3 py-1 rounded-lg text-[10px] font-black uppercase w-fit">
                        {{ $user->rol ?? 'Vendedor' }}
                    </span>
                </div>
            </td>
            <td class="p-6">
                <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 w-fit">
                    <span class="text-blue-400 font-black font-mono text-lg">
                        {{ $user->celular ?? '---' }}
                    </span>
                </div>
            </td>
            <td class="p-6">
                <div class="flex items-center gap-3 text-slate-200 font-mono text-lg font-bold bg-slate-950/50 p-3 rounded-xl border border-slate-800/50 w-fit">
                    <span class="text-yellow-500 text-xl">📧</span>
                    {{ $user->email }}
                </div>
            </td>
            <td class="p-6 text-center">
                <div class="flex justify-center gap-3">
                    <a href="{{ route('admin.usuarios.edit', $user->id) }}"
                       class="bg-blue-600 p-4 rounded-2xl hover:scale-110 transition text-xl shadow-lg shadow-blue-600/20">
                        ✏️
                    </a>
                    <form action="{{ route('admin.usuarios.destroy', $user->id) }}" method="POST" class="form-eliminar">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 p-4 rounded-2xl hover:scale-110 transition text-xl shadow-lg shadow-red-600/20">
                            🗑️
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="p-24 text-center">
                <div class="flex flex-col items-center gap-4 opacity-40">
                    <span class="text-8xl">👥</span>
                    <p class="text-white text-2xl font-bold">No hay vendedores registrados</p>
                </div>
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>

<script>
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('¿Estás seguro de eliminar a este vendedor?')) {
                this.submit();
            }
        });
    });

    document.getElementById('filtroNombre').addEventListener('input', function() {
        const val = this.value.toLowerCase().trim();
        const filas = document.querySelectorAll('.fila-usuario');
        filas.forEach(fila => {
            const nombre = fila.querySelector('.nombre-usuario-texto').innerText.toLowerCase();
            fila.style.display = nombre.includes(val) ? '' : 'none';
        });
    });
</script>
@endsection