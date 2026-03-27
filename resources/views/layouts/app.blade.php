<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LARAVEL PARTS')</title>

    {{-- Importar Tailwind CSS desde CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Configuración de Tailwind Personalizada --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-brand': '#32CD32', // Verde lima
                        'custom-bg-body': '#F3F4F6', // Gris muy suave
                        'custom-header': '#000000', // Negro
                        'custom-text-muted': '#6B7280', // Gris textos secundarios
                    }
                }
            }
        }
    </script>

    {{-- Importar Iconos de Heroicons --}}
    <script defer src="https://unpkg.com/heroicons@v2.0.18/24/outline/index.js"></script>

    {{-- Importar CSS Puro Separado --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles') {{-- Espacio para CSS extra de páginas específicas --}}
</head>
<body class="bg-custom-bg-body font-sans antialiased text-gray-900 text-lg">

    {{-- Espacio RESERVADO para el Header --}}
    @include('components.header')

    {{-- Espacio RESERVADO para el Contenido Principal --}}
    <main class="w-[95%] mx-auto py-12 flex gap-12">

        {{-- Espacio RESERVADO para el Sidebar --}}
        @include('components.sidebar')

        {{-- Espacio RESERVADO para el Catálogo de Productos --}}
        <div class="flex-1">
            @yield('content')
        </div>
    </main>

    @stack('scripts') {{-- Espacio para JS extra de páginas específicas --}}
</body>
</html>