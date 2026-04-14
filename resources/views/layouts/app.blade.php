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

    {{-- Importar CSS Puro Separado --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body class="bg-custom-bg-body font-sans antialiased text-gray-900 text-lg">

    {{-- Header --}}
    @include('components.header')

    {{-- Contenedor Principal Ajustado: Se aumentó el max-width para ocupar más pantalla --}}
    <main class="max-w-[1800px] mx-auto px-4 py-10 flex gap-8">

        {{-- Sidebar con Ancho Aumentado (w-96) para reducir espacios blancos a la izquierda --}}
        <div class="w-96 flex-shrink-0">
            <div class="sticky top-32">
                @include('components.sidebar')
            </div>
        </div>

        {{-- Contenido del Catálogo --}}
        <div class="flex-1 min-w-0">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>