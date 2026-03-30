<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ROMARTEX</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#121212] flex items-center justify-center min-h-screen font-sans">

    <div class="bg-[#0a0a0a] p-10 rounded-3xl shadow-2xl w-full max-w-md border border-gray-800">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black text-white italic tracking-tighter">ROMARTEX</h1>
            <p class="text-gray-500 text-xs uppercase tracking-[0.2em] mt-2 font-bold">Panel de Gestión</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2 ml-1">Correo Electrónico</label>
                <input type="email" name="email" required placeholder="admin@romartexsc1.com"
                    class="w-full px-5 py-4 bg-[#121212] border border-gray-800 rounded-2xl text-white focus:ring-2 focus:ring-[#4ade80] focus:border-transparent outline-none transition-all placeholder:text-gray-700">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2 ml-1">Contraseña</label>
                <input type="password" name="password" required placeholder="••••••"
                    class="w-full px-5 py-4 bg-[#121212] border border-gray-800 rounded-2xl text-white focus:ring-2 focus:ring-[#4ade80] focus:border-transparent outline-none transition-all placeholder:text-gray-700">
            </div>

            @if($errors->any())
                <div class="bg-red-900/10 border border-red-900/30 p-3 rounded-xl">
                    <p class="text-red-500 text-xs text-center">{{ $errors->first() }}</p>
                </div>
            @endif

            <button type="submit" 
                class="w-full bg-[#4ade80] hover:bg-[#3fb869] text-black font-black py-4 rounded-2xl uppercase tracking-widest transition-all active:scale-95 shadow-[0_10px_20px_rgba(74,222,128,0.15)]">
                Entrar al Sistema
            </button>
        </form>
        
        <div class="mt-8 text-center">
            <p class="text-gray-600 text-[10px] uppercase">Romartex Autopartes © 2026</p>
        </div>
    </div>

</body>
</html>