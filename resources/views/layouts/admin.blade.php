<!DOCTYPE html>
<html lang="es" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>American Iron - Admin Panel</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#0f0f0f] text-white">
        <div class="flex h-screen w-full overflow-hidden">
            
            <aside class="w-64 bg-[#141414] border-r border-neutral-900 flex flex-col justify-between p-4 shrink-0 h-full">
                <div>
                    <div class="mb-8 px-2">
                        <div class="flex items-center gap-2 text-brand-neon font-black tracking-wider text-md uppercase">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            Iron Admin
                        </div>
                        <span class="text-[10px] text-gray-500 block pl-7 -mt-1">Gestión Central • Santa Ana</span>
                    </div>

                    <div>
                        <span class="text-[10px] uppercase font-bold text-gray-500 tracking-wider block px-2 mb-2">Administración</span>
                        <nav class="space-y-1">
                            <a href="/admin" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin') ? 'bg-[#1e1e1e] text-brand-neon border-l-2 border-brand-neon' : 'text-gray-400 hover:bg-[#1a1a1a] hover:text-white transition' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                Vista General
                            </a>
                            <a href="/admin/members" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/members*') ? 'bg-[#1e1e1e] text-brand-neon border-l-2 border-brand-neon' : 'text-gray-400 hover:bg-[#1a1a1a] hover:text-white transition' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Control de Miembros
                            </a>
                            <a href="/admin/access" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/access*') ? 'bg-[#1e1e1e] text-brand-neon border-l-2 border-brand-neon' : 'text-gray-400 hover:bg-[#1a1a1a] hover:text-white transition' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                Historial de Accesos
                            </a>
                            <a href="/admin/wompi" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/wompi*') ? 'bg-[#1e1e1e] text-brand-neon border-l-2 border-brand-neon' : 'text-gray-400 hover:bg-[#1a1a1a] hover:text-white transition' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Pagos Wompi
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="border-t border-neutral-900 pt-4 flex flex-col gap-3 px-2">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-neutral-800 text-white font-bold flex items-center justify-center text-xs border border-neutral-700 uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="flex flex-col truncate">
                            <span class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-brand-neon uppercase font-bold tracking-wider">Staff</span>
                        </div>
                    </div>

                    <form id="admin-logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                        @csrf
                    </form>

                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();"
                       class="flex items-center justify-center gap-2 w-full px-3 py-2 text-[11px] font-black uppercase tracking-wider text-red-400 hover:bg-red-950/30 hover:text-red-300 transition rounded-lg border border-red-950/20 bg-[#1c1c1c]">
                        <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Cerrar Sesión
                    </a>
                </div>
            </aside>

            <main class="flex-1 bg-[#0c0c0c] p-8 overflow-y-auto h-full">
                @yield('content')
            </main>

        </div>
    </body>
</html>