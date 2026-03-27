{{-- resources/views/catalogo.blade.php --}}

{{-- 1. Heredar del Layout Base --}}
@extends('layouts.app')

{{-- 2. Definir Título de esta Página --}}
@section('title', 'Catálogo Completo | LARAVEL PARTS')

{{-- 3. Insertar Contenido Principal --}}
@section('content')
    <div class="mb-12 pb-8 border-b border-gray-200">
        <h1 class="text-5xl font-extrabold mb-3 text-gray-950 tracking-tight">Catálogo de Autopartes</h1>
        <p class="text-gray-600 text-xl max-w-3xl">Encuentra las partes que necesitas con filtros avanzados y precisión garantizada.</p>
    </div>

    {{-- Grid de Productos Fluid Adaptable --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">

        {{-- Datos de Productos (Sección PHP limpia) --}}
        @php
            $productos = [
                [ 'id' => 1, 'imagen' => 'https://via.placeholder.com/350x250/E5E7EB/000000?text=MOTOR+ARRANQUE', 'categoria' => 'Inducidos', 'nombre' => 'Motor de Arranque Toyota Corolla', 'marca' => 'Bosch', 'precio_oferta' => '125.99', 'precio_lista' => '189.99', 'descuento' => '-34%', 'agotado' => false ],
                [ 'id' => 2, 'imagen' => 'https://via.placeholder.com/350x250/E5E7EB/000000?text=ALTERNADOR', 'categoria' => 'Reguladores', 'nombre' => 'Alternador Chevrolet Aveo', 'marca' => 'Delco', 'precio_oferta' => '85.50', 'precio_lista' => null, 'descuento' => null, 'agotado' => false ],
                [ 'id' => 3, 'imagen' => 'https://via.placeholder.com/350x250/E5E7EB/000000?text=RELAY', 'categoria' => 'Reguladores', 'nombre' => 'Relay Regulador de Voltaje Universal Denso', 'marca' => 'Denso', 'precio_oferta' => '45.00', 'precio_lista' => '60.00', 'descuento' => '-25%', 'agotado' => true ],
                [ 'id' => 4, 'imagen' => 'https://via.placeholder.com/350x250/E5E7EB/000000?text=BOBINA', 'categoria' => 'Inducidos', 'nombre' => 'Bobina de Encendido Nissan Sentra B15', 'marca' => 'Nippondenso', 'precio_oferta' => '95.75', 'precio_lista' => null, 'descuento' => null, 'agotado' => false ],
                [ 'id' => 5, 'imagen' => 'https://via.placeholder.com/350x250/E5E7EB/000000?text=EMBRAGUE', 'categoria' => 'Inducidos', 'nombre' => 'Kit de Embrague Completo', 'marca' => 'Bosch', 'precio_oferta' => '210.00', 'precio_lista' => '299.99', 'descuento' => '-30%', 'agotado' => false ],
                [ 'id' => 6, 'imagen' => 'https://via.placeholder.com/350x250/E5E7EB/000000?text=BOMBA+AGUA', 'categoria' => 'Reguladores', 'nombre' => 'Bomba de Agua Alta Presión', 'marca' => 'Delco', 'precio_oferta' => '120.20', 'precio_lista' => null, 'descuento' => null, 'agotado' => false ],
                [ 'id' => 7, 'imagen' => 'https://via.placeholder.com/350x250/E5E7EB/000000?text=SENSOR', 'categoria' => 'Reguladores', 'nombre' => 'Sensor de Oxígeno', 'marca' => 'Denso', 'precio_oferta' => '65.00', 'precio_lista' => '89.50', 'descuento' => '-27%', 'agotado' => false ],
                [ 'id' => 8, 'imagen' => 'https://via.placeholder.com/350x250/E5E7EB/000000?text=PASTILLAS', 'categoria' => 'Inducidos', 'nombre' => 'Pastillas de Freno', 'marca' => 'Nippondenso', 'precio_oferta' => '105.75', 'precio_lista' => null, 'descuento' => null, 'agotado' => false ],
            ];
        @endphp

        @foreach($productos as $producto)
            {{-- Tarjeta de Producto Modularizable --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col group relative">
                {{-- Imagen y Badges --}}
                <div class="relative w-full h-60 overflow-hidden bg-gray-50 border-b border-gray-100">
                    <img src="{{ $producto['imagen'] }}" alt="{{ $producto['nombre'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                    {{-- Badge Descuento --}}
                    @if($producto['descuento'])
                        <span class="absolute top-4 left-4 bg-custom-brand text-black font-extrabold text-sm px-4 py-1.5 rounded-full shadow-md z-10">
                            {{ $producto['descuento'] }}
                        </span>
                    @endif

                    {{-- Overlay AGOTADO --}}
                    @if($producto['agotado'])
                        <div class="absolute inset-0 bg-black bg-opacity-70 flex items-center justify-center z-20">
                            <span class="text-white font-extrabold text-2xl tracking-widest uppercase">Agotado</span>
                        </div>
                    @endif
                </div>

                {{-- Detalles del Producto --}}
                <div class="p-6 flex flex-col flex-grow text-base">
                    <p class="text-custom-text-muted text-sm font-medium uppercase tracking-wider mb-2">{{ $producto['categoria'] }}</p>
                    <h3 class="font-semibold text-gray-950 mb-2 line-clamp-2 h-16 text-xl group-hover:text-custom-brand transition-colors">{{ $producto['nombre'] }}</h3>
                    <p class="text-custom-text-muted text-sm mb-5 font-mono">{{ $producto['marca'] }}</p>

                    {{-- Precios --}}
                    <div class="flex items-baseline gap-3.5 mt-auto mb-6 pb-4 border-b border-gray-100">
                        <span class="text-3xl font-extrabold text-gray-950">${{ $producto['precio_oferta'] }}</span>
                        @if($producto['precio_lista'])
                            <span class="text-lg text-gray-500 line-through">${{ $producto['precio_lista'] }}</span>
                        @endif
                    </div>

                    {{-- Botón de Acción --}}
                    @if($producto['agotado'])
                        <button disabled class="w-full flex items-center justify-center gap-3 bg-gray-200 text-gray-500 font-bold py-3.5 px-6 rounded-xl cursor-not-allowed">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                            No disponible
                        </button>
                    @else
                        <button class="w-full flex items-center justify-center gap-3 bg-black text-white font-bold py-3.5 px-6 rounded-xl hover:bg-gray-800 transition transform hover:-translate-y-0.5 active:translate-y-0 shadow-md">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Ver Detalles
                        </button>
                    @endif
                </div>
            </div>
        @endforeach

    </div>
@endsection