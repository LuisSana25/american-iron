<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>American Iron - Plataforma</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#0f0f0f] text-white" x-data="{ 
        openSettings: false, 
        openEditProfile: false,
        openSidebar: false, /* 🚀 Controla el menú en móviles */
        memberData: { 
            name: '{{ Auth::user()->name }}', 
            phone: '{{ Auth::user()->phone ?? '' }}', 
            email: '{{ Auth::user()->email }}', 
            birth: '{{ Auth::user()->birthdate ?? '' }}', 
            emergency_name: '{{ Auth::user()->emergency_name ?? '' }}', 
            emergency_phone: '{{ Auth::user()->emergency_phone ?? '' }}' 
        }
    }">
        <div class="flex min-h-screen relative overflow-x-hidden">
            
            <!-- 📱 CAPA OSCURA DE FONDO (Sólo visible en móviles cuando el menú está abierto) -->
            <div x-show="openSidebar" 
                 @click="openSidebar = false" 
                 x-transition:opacity
                 class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 md:hidden" 
                 x-cloak>
            </div>

            <!-- aside BARRA LATERAL (Responsiva: Flotante en móviles, fija en escritorio) -->
            <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-[#141414] border-r border-neutral-900 flex flex-col justify-between p-4 shrink-0 transform -translate-x-full transition-transform duration-300 ease-in-out md:static md:translate-x-0"
                   :class="openSidebar ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
                <div>
                    <!-- Encabezado con botón para cerrar menú en celular -->
                    <div class="mb-6 px-2 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-white font-black tracking-wider text-md uppercase">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            American Iron
                        </div>
                        <button @click="openSidebar = false" class="text-gray-400 hover:text-white md:hidden focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <span class="text-[10px] text-gray-500 block pl-9 -mt-7 mb-6">Santa Ana, El Salvador</span>

                    <div class="mb-8 bg-[#1e2200] border border-[#3c4100] rounded-lg p-2.5 flex items-center gap-3">
                        <span class="text-brand-neon animate-pulse">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </span>
                        <span class="text-xs font-bold text-brand-neon">WiFi Gratis</span>
                    </div>

                    <div>
                        <span class="text-[10px] uppercase font-bold text-gray-500 tracking-wider block px-2 mb-2">Plataforma</span>
                        <nav class="space-y-1">
                            <a href="/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium bg-[#1e1e1e] text-brand-neon border-l-2 border-brand-neon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                Panel de Control
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:bg-[#1a1a1a] hover:text-white transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                Escanear Equipo
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:bg-[#1a1a1a] hover:text-white transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Coworking Space
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:bg-[#1a1a1a] hover:text-white transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h2.945M11 20.955V18.5a2.5 2.5 0 012.5-2.5h2.5a2.5 2.5 0 002.5-2.5V11a.5.5 0 00-.5-.5H18a2 2 0 01-2-2v-.5A2.5 2.5 0 0118.5 6v-.165"></path></svg>
                                Gimnasio / Gym
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="border-t border-neutral-900 pt-4 flex items-center gap-3 px-2">
                    <div class="w-9 h-9 rounded-full bg-brand-neon text-black font-bold flex items-center justify-center text-xs shrink-0" x-text="memberData.name.split(' ').map(n => n[0]).join('')"></div>
                    <div class="flex flex-col truncate">
                        <span class="text-xs font-bold text-white truncate" x-text="memberData.name"></span>
                        <span class="text-[10px] text-gray-500 capitalize">{{ Auth::user()->role }}</span>
                    </div>
                </div>
            </aside>

            <!-- CONTENEDOR PRINCIPAL -->
            <main class="flex-1 flex flex-col min-w-0 bg-[#0c0c0c]">
                
                <!-- CABECERA ADAPTADA (Justificación dinámica para el botón móvil) -->
                <header class="h-14 border-b border-neutral-900 flex items-center justify-between md:justify-end px-4 sm:px-6 gap-4 relative bg-[#0c0c0c] z-20">
                    
                    <!-- 🍔 Botón Hamburguesa (Sólo visible en móviles) -->
                    <button @click="openSidebar = !openSidebar" class="text-gray-400 hover:text-white transition focus:outline-none md:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div class="flex items-center gap-4">
                        <span class="text-xs font-semibold px-2 py-1 bg-[#1a1a1a] rounded text-gray-400 cursor-pointer hover:text-white">EN</span>
                        
                        <div class="relative">
                            <button @click="openSettings = !openSettings" @click.away="openSettings = false" class="text-gray-400 hover:text-white transition focus:outline-none mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </button>

                            <div x-show="openSettings" 
                                 x-transition 
                                 class="absolute right-0 mt-2 w-48 bg-[#141414] border border-neutral-800 rounded-xl shadow-2xl py-1 z-50 overflow-hidden" 
                                 x-cloak>
                                <div class="px-4 py-2 border-b border-neutral-900 bg-[#1c1c1c]/40">
                                    <p class="text-xs text-gray-500 font-semibold">Opciones de Cuenta</p>
                                </div>
                                <button @click="openEditProfile = true; openSettings = false" class="w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-[#1c1c1c] hover:text-white transition flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Mi Perfil / Editar
                                </button>
                                <hr class="border-neutral-900">
                                
                                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                                    @csrf
                                </form>

                                <a href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   class="block px-4 py-2.5 text-sm text-red-400 hover:bg-red-950/20 hover:text-red-300 transition flex items-center gap-2 font-medium">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Cerrar Sesión
                                </a>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- 🌐 PADDING ADAPTADO (p-4 en celulares, p-8 en computadoras) -->
                <div class="p-4 sm:p-8 flex-1 overflow-y-auto">
                    {{ $slot }}
                </div>
            </main>

        </div>

        <!-- MODAL DE PERFIL RESPONSIVO -->
        <div x-show="openEditProfile" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" x-cloak>
            <div @click.away="openEditProfile = false" class="bg-[#141414] border border-neutral-800 w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl max-h-[90vh] flex flex-col">
                <div class="px-6 py-4 border-b border-neutral-800 flex justify-between items-center bg-[#1c1c1c]/40 shrink-0">
                    <h2 class="text-sm font-black text-white uppercase tracking-wider">Configuración del Miembro</h2>
                    <button @click="openEditProfile = false" class="text-gray-400 hover:text-white text-xl focus:outline-none">&times;</button>
                </div>

                <form @submit.prevent="openEditProfile = false" class="p-6 space-y-4 overflow-y-auto flex-1">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Nombre Completo</label>
                        <input type="text" x-model="memberData.name" class="w-full bg-[#1c1c1c] border-transparent rounded-lg text-white text-sm px-4 py-2 focus:border-brand-neon focus:ring-0" required>
                    </div>
                    
                    <!-- 📱 Reemplazado grid-cols-2 por grid-cols-1 sm:grid-cols-2 -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Dirección de Correo</label>
                            <input type="email" x-model="memberData.email" class="w-full bg-[#1c1c1c] border-transparent rounded-lg text-white text-sm px-4 py-2 focus:border-brand-neon focus:ring-0" disabled>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Teléfono Personal</label>
                            <input type="text" x-model="memberData.phone" class="w-full bg-[#1c1c1c] border-transparent rounded-lg text-white text-sm px-4 py-2 focus:border-brand-neon focus:ring-0" required>
                        </div>
                    </div>

                    <div class="p-4 bg-[#1c1c1c]/40 border border-neutral-900 rounded-xl space-y-3">
                        <span class="text-[10px] uppercase font-black text-brand-neon tracking-wider block">Contacto de Emergencia</span>
                        <!-- 📱 Reemplazado grid-cols-2 por grid-cols-1 sm:grid-cols-2 -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Nombre Contacto</label>
                                <input type="text" x-model="memberData.emergency_name" class="w-full bg-[#141414] border-transparent rounded-lg text-white text-xs px-3 py-1.5 focus:border-brand-neon focus:ring-0" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Teléfono Contacto</label>
                                <input type="text" x-model="memberData.emergency_phone" class="w-full bg-[#141414] border-transparent rounded-lg text-white text-xs px-3 py-1.5 focus:border-brand-neon focus:ring-0" required>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-neutral-900 shrink-0">
                        <button type="button" @click="openEditProfile = false" class="text-xs text-gray-400 hover:text-white px-4 py-2 font-semibold">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-brand-neon hover:bg-[#b3e600] text-black font-black text-xs uppercase tracking-wider px-5 py-2 rounded-lg transition">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </body>
</html>