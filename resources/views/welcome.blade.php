<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>American Iron - Transforma tu Cuerpo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-black text-white">

    <nav class="fixed top-0 w-full bg-black/90 backdrop-blur-md border-b border-neutral-900 z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="#" class="flex items-center gap-2 text-xl font-black tracking-wider uppercase text-white">
                <svg class="w-6 h-6 text-brand-neon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                American Iron
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-gray-400">
                <a href="#inicio" class="hover:text-brand-neon transition">Inicio</a>
                <a href="#entrenamiento" class="hover:text-brand-neon transition">Cómo Entrenamos</a>
                <a href="#membresias" class="hover:text-brand-neon transition">Membresías</a>
                <a href="#informacion" class="hover:text-brand-neon transition">Horarios y Ubicación</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-bold text-gray-300 hover:text-white transition">
                    Ingresar
                </a>
                <a href="/register" class="bg-brand-neon hover:bg-[#b3e600] text-black text-xs font-black uppercase tracking-wider px-4 py-2 rounded-lg transition duration-200">
                    Únete Hoy
                </a>
            </div>
        </div>
    </nav>

    <header id="inicio" class="relative min-h-screen pt-16 flex items-center justify-center overflow-hidden bg-[#050505]">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/50 to-black z-10"></div>
        
        <div class="relative z-20 max-w-4xl mx-auto px-6 text-center space-y-6">
            <span class="text-brand-neon font-black text-xs tracking-widest uppercase bg-brand-neon/10 border border-brand-neon/30 px-3 py-1 rounded-full">
                Fase Inicial Abierta
            </span>
            <h1 class="text-4xl md:text-7xl font-extrabold text-white uppercase tracking-tighter leading-none">
                Transforma tu cuerpo <br>en <span class="text-brand-neon">90 días.</span>
            </h1>
            <p class="text-gray-400 max-w-xl mx-auto text-xs md:text-base leading-relaxed">
                Entrena en las instalaciones más completas de Santa Ana. Maquinaria premium, zona de coworking integrada y ambiente de alto nivel. Un paso. Sin excusas.
            </p>
            <div class="pt-4 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/register" class="bg-brand-neon hover:bg-[#b3e600] text-black font-black text-sm uppercase tracking-wide px-8 py-3.5 rounded-xl transition shadow-lg shadow-brand-neon/10 text-center">
                    Comienza tu Evaluación de 90 Días
                </a>
                <a href="#membresias" class="bg-neutral-900 hover:bg-neutral-800 text-white font-bold text-sm px-8 py-3.5 rounded-xl transition border border-neutral-800 text-center">
                    Ver Paquetes
                </a>
            </div>
        </div>
    </header>

    <section id="entrenamiento" class="py-24 bg-black border-t border-neutral-950">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl font-black uppercase tracking-tight text-white mb-2">Cómo Entrenamos</h2>
                <p class="text-sm text-gray-500">Un sistema optimizado para que alcances tu máximo rendimiento físico.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-[#0a0a0a] border border-neutral-900 p-8 rounded-2xl space-y-4">
                    <div class="text-brand-neon font-black text-3xl">01</div>
                    <h3 class="text-lg font-bold text-white">Evaluación Inicial</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Analizamos tu composición corporal y objetivos mecánicos antes de asignarte una rutina.</p>
                </div>
                <div class="bg-[#0a0a0a] border border-neutral-900 p-8 rounded-2xl space-y-4">
                    <div class="text-brand-neon font-black text-3xl">02</div>
                    <h3 class="text-lg font-bold text-white">Fuerza de Hierro</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Rutinas enfocadas en sobrecarga progresiva usando barras, mancuernas masivas y poleas premium.</p>
                </div>
                <div class="bg-[#0a0a0a] border border-neutral-900 p-8 rounded-2xl space-y-4">
                    <div class="text-brand-neon font-black text-3xl">03</div>
                    <h3 class="text-lg font-bold text-white">Consistencia</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Monitoreo de tus accesos y estado para asegurar que cumplas las metas de entrenamiento semanales.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 💳 SECCIÓN DE MEMBRESÍAS CONECTADA CON MARIADB -->
    <section id="membresias" class="py-24 bg-[#050505] border-t border-neutral-950">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl font-black uppercase tracking-tight text-white mb-2">Paquetes de Entrenamiento</h2>
                <p class="text-sm text-gray-500">Elige el pase ideal para desatar tu potencial de hierro.</p>
            </div>

            <!-- Grid Responsivo Dinámico -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @foreach($plans as $plan)
                    <div class="bg-[#141414] p-6 rounded-2xl flex flex-col justify-between relative {{ $plan->name == 'Iron Mensual' ? 'border-2 border-brand-neon shadow-2xl shadow-brand-neon/5' : 'border border-neutral-900' }}">
                        
                        @if($plan->name == 'Iron Mensual')
                            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-brand-neon text-black text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full">Recomendado</div>
                        @endif

                        <div>
                            <h4 class="text-md font-bold text-white mb-4">{{ $plan->name }}</h4>
                            
                            <div class="text-4xl font-black mb-6 {{ $plan->name == 'Iron Mensual' ? 'text-brand-neon' : 'text-white' }}">
                                ${{ number_format($plan->price, 2) }}
                                <span class="text-xs text-gray-500 font-medium">
                                    @if(Str::contains(Str::lower($plan->name), 'inscrip'))
                                        /único
                                    @elseif(Str::contains(Str::lower($plan->name), 'mensual'))
                                        /mes
                                    @elseif(Str::contains(Str::lower($plan->name), 'trimestral'))
                                        /3 meses
                                    @else
                                        /{{ $plan->duration_days }} días
                                    @endif
                                </span>
                            </div>

                            <!-- Desgloses Dinámicos según el tipo de Plan en MariaDB -->
                            @if(Str::contains(Str::lower($plan->name), 'inscrip'))
                                <p class="text-xs text-gray-400 leading-relaxed">Pago único de ingreso para registrar tu perfil digital en el sistema y otorgar accesos automáticos.</p>
                            @elseif(Str::contains(Str::lower($plan->name), 'mensual'))
                                <ul class="text-xs text-gray-400 space-y-2">
                                    <li>✓ Acceso total al gimnasio y pesas</li>
                                    <li>✓ Uso de vestidores y regaderas</li>
                                    <li>✓ Zona Coworking integrada</li>
                                    <li>✓ Conexión WiFi Gratis de alta velocidad</li>
                                </ul>
                            @elseif(Str::contains(Str::lower($plan->name), 'trimestral'))
                                <p class="text-xs text-gray-400 leading-relaxed">Ahorra en tu mensualidad asegurando tu trimestre de disciplina continuo. Opción de congelar hasta 7 días por imprevistos.</p>
                            @else
                                <ul class="text-xs text-gray-400 space-y-2">
                                    <li>✓ Acceso completo a maquinaria premium</li>
                                    <li>✓ Zona de Coworking de alta velocidad</li>
                                    <li>✓ Ingreso mediante escáner digital</li>
                                </ul>
                            @endif
                        </div>

                        <!-- Botón Dinámico hacia el Registro -->
                        <a href="/register" class="mt-8 block w-full text-center py-3 rounded-xl text-xs uppercase tracking-wider transition font-bold {{ $plan->name == 'Iron Mensual' ? 'bg-brand-neon hover:bg-[#b3e600] text-black font-black' : 'bg-neutral-900 hover:bg-neutral-800 text-white' }}">
                            @if(Str::contains(Str::lower($plan->name), 'inscrip'))
                                Inscribirme
                            @elseif(Str::contains(Str::lower($plan->name), 'mensual'))
                                Obtener Pase Mensual
                            @else
                                Comprar {{ $plan->name }}
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="informacion" class="py-24 bg-black border-t border-neutral-950">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            
            <div class="space-y-6">
                <div class="space-y-2">
                    <h2 class="text-3xl font-black uppercase tracking-tight text-white">La Ubicación</h2>
                    <p class="text-sm text-brand-neon font-bold">Santa Ana, El Salvador</p>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Encuéntranos en el corazón de Santa Ana. Instalaciones de primer nivel diseñadas para brindarte comodidad tanto en tus entrenamientos de alta exigencia como en tus jornadas de trabajo remoto en nuestra zona coworking.
                </p>
                
                <div class="bg-[#0a0a0a] border border-neutral-900 rounded-xl overflow-hidden max-w-sm">
                    <div class="px-4 py-2.5 bg-[#141414] text-xs font-bold uppercase tracking-wider text-gray-400 border-b border-neutral-900">Horarios Operativos</div>
                    <div class="p-4 text-xs space-y-2 font-medium text-gray-300">
                        <div class="flex justify-between border-b border-neutral-900/60 pb-1"><span>Lunes a Viernes</span><span class="text-white font-bold">5:00 AM - 9:00 PM</span></div>
                        <div class="flex justify-between border-b border-neutral-900/60 pb-1"><span>Sábados</span><span class="text-white font-bold">6:00 AM - 4:00 PM</span></div>
                        <div class="flex justify-between"><span>Domingos</span><span class="text-red-400 font-bold">Cerrado</span></div>
                    </div>
                </div>
            </div>

            <div class="h-80 bg-neutral-900 border border-neutral-800 rounded-2xl flex flex-col items-center justify-center p-6 text-center relative overflow-hidden group">
                <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,#808080_1px,transparent_1px),linear-gradient(to_bottom,#808080_1px,transparent_1px)] bg-[size:24px_24px]"></div>
                <div class="relative z-10 space-y-2">
                    <svg class="w-8 h-8 text-brand-neon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h4 class="text-sm font-bold text-white">American Iron Gym</h4>
                    <p class="text-xs text-gray-500 max-w-xs mx-auto">Ubicación física exacta mapeada en Santa Ana, El Salvador</p>
                </div>
            </div>

        </div>
    </section>

    <footer class="py-8 bg-[#050505] border-t border-neutral-900 text-center text-xs text-gray-600 font-medium">
        <p class="uppercase tracking-widest mb-1 text-gray-500">Se mejor. Se fuerte. Se de Hierro.</p>
        <p>&copy; {{ date('Y') }} American Iron. Todos los derechos reservados.</p>
    </footer>

</body>
</html>