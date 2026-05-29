<x-app-layout>
    <div class="max-w-5xl mx-auto py-6">
        
        <!-- Encabezado -->
        <div class="mb-10 text-center max-w-2xl mx-auto">
            <h1 class="text-3xl font-black text-white uppercase tracking-tight mb-2">Activa tu Membresía</h1>
            <p class="text-gray-400 text-sm">Selecciona tu plan de entrenamiento. Al estar en entorno de desarrollo local, procesaremos una simulación de pago enlazada a tu controlador.</p>
        </div>

        <!-- Grid de Planes Dinámicos (Traídos desde MariaDB) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            @foreach($plans as $plan)
                <div class="bg-[#141414] border {{ $plan->name == 'Iron Mensual' ? 'border-brand-neon shadow-2xl shadow-brand-neon/5' : 'border-neutral-900' }} rounded-2xl p-8 flex flex-col justify-between relative overflow-hidden">
                    
                    @if($plan->name == 'Iron Mensual')
                        <div class="absolute top-0 right-0 bg-brand-neon text-black text-[10px] font-black uppercase tracking-widest px-4 py-1 rounded-bl-lg">Recomendado</div>
                    @endif

                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-white mb-2">{{ $plan->name }}</h3>
                        <div class="flex items-baseline gap-1 mb-6">
                            <span class="text-5xl font-black {{ $plan->name == 'Iron Mensual' ? 'text-brand-neon' : 'text-white' }}">${{ number_format($plan->price, 2) }}</span>
                            <span class="text-sm text-gray-500 font-medium">USD / {{ $plan->duration_days }} días</span>
                        </div>
                        
                        <ul class="text-sm text-gray-400 space-y-3">
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 
                                Acceso total a maquinaria de pesas
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 
                                Zona de Coworking de alta velocidad
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 
                                Ingreso mediante escáner digital
                            </li>
                        </ul>
                    </div>

                    <!-- BOTÓN DE ENTORNO LOCAL (Sandbox de Alta Fidelidad) -->
                    <div class="w-full">
                        <!-- Redirige simulando las variables exactas que inyecta Wompi (ID de transacción aleatorio) -->
                        <a href="{{ route('checkout.success') }}?plan_id={{ $plan->id }}&idTransaccion=wmp_test_{{ Str::random(10) }}" 
                           class="block w-full text-center bg-brand-neon hover:bg-[#b3e600] text-black font-black text-xs uppercase tracking-wider py-3.5 rounded-xl transition duration-200">
                            Pagar ${{ number_format($plan->price, 2) }} (Simular Wompi SV)
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Banner de Información Técnica -->
        <div class="mt-12 bg-[#141414] border border-neutral-900 rounded-xl p-4 max-w-xl mx-auto text-center">
            <p class="text-xs text-gray-500">
                <strong>Modo Sandbox Activo:</strong> Utilizando App ID: <code class="text-purple-400 font-mono">{{ env('WOMPI_APP_ID') }}</code>. Cuando el proyecto se suba a producción con HTTPS, reemplazaremos este botón por el script asíncrono del Widget de Wompi.
            </p>
        </div>

    </div>
</x-app-layout>