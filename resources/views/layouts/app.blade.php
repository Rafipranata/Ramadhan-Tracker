<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ramadhan Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
       body {
            background: linear-gradient(to bottom right, #000428, #004e92);
            color: white;
            min-height: 100vh; /* Warna Slate 900 */
        }
    </style>
</head>
<body class="antialiased pb-24">
    
    @yield('content')

    <nav class="fixed bottom-0 left-0 right-0 bg-slate-900/80 backdrop-blur-lg border-t border-white/10 pb-6 pt-3 px-6 z-50">
        <div class="max-w-md mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('home') ? 'text-blue-400' : 'text-white/40' }}">
                <div class="text-xl">🏠</div>
                <span class="text-[10px]">Home</span>
            </a>
            <a href="{{ route('dzikir') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('dzikir') ? 'text-blue-400' : 'text-white/40' }}">
                <div class="text-xl">📿</div>
                <span class="text-[10px]">Dzikir</span>
            </a>
            <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('profile') ? 'text-blue-400' : 'text-white/40' }}">
                <div class="text-xl">👤</div>
                <span class="text-[10px]">User</span>
            </a>
        </div>
    </nav>
</body>
</html>