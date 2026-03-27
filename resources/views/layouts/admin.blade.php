<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - ROMARTEX</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-admin-dark { background-color: #0f172a; }
        .bg-admin-card { background-color: #1e293b; }
    </style>
</head>
<body class="bg-admin-dark text-white font-sans">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 border-r border-slate-800 p-6">
            <h1 class="text-2xl font-black italic text-green-400 mb-10">ROMARTEX ADMIN</h1>
            <nav class="space-y-4">
                <a href="{{ route('admin.dashboard') }}" class="block p-3 rounded-lg hover:bg-slate-800 transition">📊 Dashboard</a>
                
                <div class="pt-4 pb-2 text-xs font-bold text-slate-500 uppercase">Gestión de Repuestos</div>
                
                <a href="{{ route('admin.repuestos.index', ['tipo' => 'bendix']) }}" class="block p-3 rounded-lg hover:bg-slate-800 transition">⚙️ Bendix</a>
                <a href="{{ route('admin.repuestos.index', ['tipo' => 'inducido']) }}" class="block p-3 rounded-lg hover:bg-slate-800 transition">⚡ Inducidos</a>
                <a href="{{ route('admin.repuestos.index', ['tipo' => 'regulador']) }}" class="block p-3 rounded-lg hover:bg-slate-800 transition">🔌 Reguladores</a>

                <div class="pt-10">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left p-3 text-red-400 hover:bg-red-400/10 rounded-lg transition">
                            🚪 Cerrar Sesión
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <main class="flex-1 p-10">
            @yield('admin_content')
        </main>
    </div>
</body>
</html>