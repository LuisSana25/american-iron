<x-app-layout>
    <div class="mb-10 text-center md:text-left">
        <h1 class="text-3xl font-black text-white tracking-tight uppercase mb-2">
            Membresías Disponibles
        </h1>
        <p class="text-sm text-gray-400">
            Selecciona el plan que mejor se adapte a tus objetivos fitness en <span class="text-brand-neon font-bold">American Iron</span>.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl">
        
        <div class="bg-[#141414] border border-neutral-900 rounded-2xl p-6 flex flex-col justify-between hover:border-neutral-800 transition duration-300 relative overflow-hidden group">
            <div>
                <h3 class="text-lg font-bold text-white mb-2">Inscripción Base</h3>
                <p class="text-xs text-gray-500 mb-6">Pago único de ingreso a las instalaciones.</p>
                <div class="flex items-baseline text-white mb-6">
                    <span class="text-2xl font-semibold">$</span>
                    <span class="text-5xl font-black tracking-tight">20</span>
                    <span class="text-sm font-medium text-gray-500 ml-1">/único</span>
                </div>
                
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-neon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Registro oficial en el sistema
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-neon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Código de acceso digital inmediato
                    </li>
                </ul>
            </div>
            <div class="mt-8">
                <a href="/checkout?plan=inscripcion&price=20" class="block w-full text-center bg-[#1c1c1c] hover:bg-[#262626] text-white font-bold py-3 px-4 rounded-xl text-sm transition">
                    Adquirir Pase
                </a>
            </div>
        </div>

        <div class="bg-[#141414] border-2 border-brand-neon rounded-2xl p-6 flex flex-col justify-between hover:border-brand-neon transition duration-300 relative overflow-hidden shadow-2xl shadow-brand-neon/5">
            <div class="absolute top-0 right-0 bg-brand-neon text-black text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-bl-lg">
                Popular
            </div>
            
            <div>
                <h3 class="text-lg font-bold text-white mb-2">Iron Mensual</h3>
                <p class="text-xs text-gray-500 mb-6">Acceso completo por 30 días calendario.</p>
                <div class="flex items-baseline text-white mb-6">
                    <span class="text-2xl font-semibold">$</span>
                    <span class="text-5xl font-black tracking-tight">25</span>
                    <span class="text-sm font-medium text-gray-500 ml-1">/mes</span>
                </div>
                
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-neon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Acceso ilimitado al área de pesas
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-neon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Uso de casilleros y duchas
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-neon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Acceso al área de Coworking Space
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-neon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Conexión de alta velocidad (WiFi Gratis)
                    </li>
                </ul>
            </div>
            <div class="mt-8">
                <a href="/checkout?plan=mensual&price=25" class="block w-full text-center bg-brand-neon hover:bg-[#b3e600] text-black font-bold py-3 px-4 rounded-xl text-sm transition">
                    Seleccionar Plan →
                </a>
            </div>
        </div>

        <div class="bg-[#141414] border border-neutral-900 rounded-2xl p-6 flex flex-col justify-between hover:border-neutral-800 transition duration-300 relative overflow-hidden group">
            <div>
                <h3 class="text-lg font-bold text-white mb-2">Iron Trimestral</h3>
                <p class="text-xs text-gray-500 mb-6">Plan de 3 meses con descuento especial.</p>
                <div class="flex items-baseline text-white mb-6">
                    <span class="text-2xl font-semibold">$</span>
                    <span class="text-5xl font-black tracking-tight">60</span>
                    <span class="text-sm font-medium text-gray-500 ml-1">/3 meses</span>
                </div>
                
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-neon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Todos los beneficios del plan mensual
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-neon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Ahorro del 20% comparado a mes a mes
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-neon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Congelación de membresía por 7 días
                    </li>
                </ul>
            </div>
            <div class="mt-8">
                <a href="/checkout?plan=trimestral&price=60" class="block w-full text-center bg-[#1c1c1c] hover:bg-[#262626] text-white font-bold py-3 px-4 rounded-xl text-sm transition">
                    Seleccionar Plan
                </a>
            </div>
        </div>

    </div>
</x-app-layout>