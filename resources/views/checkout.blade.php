<x-app-layout>
    <div class="max-w-5xl mx-auto py-6">
        
        <div class="mb-10 text-center max-w-2xl mx-auto">
            <h1 class="text-3xl font-black text-white uppercase tracking-tight mb-2">Activa tu Membresía</h1>
            <p class="text-gray-400 text-sm">Selecciona tu plan de entrenamiento. Los pagos son procesados de forma segura mediante la pasarela encriptada y certificada de Wompi El Salvador.</p>
        </div>

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

                    <!-- 💳 WIDGET REAL DE WOMPI (Limpio de formularios anidados) -->
                    <div class="w-full text-center wompi-container" x-ignore>
                        <script 
                            src="https://wompisv.s3.amazonaws.com/widget/wompi.js"
                            data-wompi-appid="{{ config('services.wompi.app_id') }}"
                            data-wompi-amount="{{ number_format($plan->price, 2, '.', '') }}"
                            data-wompi-currency="USD"
                            data-wompi-idtransaccion="{{ 'IRON-' . auth()->id() . '-' . $plan->id . '-' . time() }}"
                            data-wompi-nombre="{{ $plan->name }}"
                            data-wompi-config-color="#b3e600" 
                            data-wompi-urlredireccion="{{ route('checkout.success', ['plan_id' => $plan->id]) }}">
                        </script>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-12 bg-[#141414] border border-neutral-900 rounded-xl p-4 max-w-xl mx-auto text-center">
            <p class="text-xs text-gray-500">
                🔒 Conexión Segura HTTPS activa. App ID cargado desde entorno: <code class="text-brand-neon font-mono">{{ substr(config('services.wompi.app_id'), 0, 8) }}********</code>
            </p>
        </div>

    </div>
</x-app-layout>