<x-app-layout>
    <div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <a href="/checkout" class="text-brand-neon hover:text-white text-sm font-medium flex items-center gap-2 transition-colors">
                &larr; Volver a los planes
            </a>
        </div>

        <div class="bg-[#141414] border border-neutral-900 rounded-2xl p-8 shadow-2xl">
            <h2 class="text-2xl font-black text-white uppercase tracking-tight mb-8 border-b border-neutral-800 pb-4">Resumen de Membresía</h2>
            
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h3 class="text-xl font-bold text-white">{{ $plan->name }}</h3>
                    <p class="text-gray-500 text-sm mt-1">Acceso garantizado por {{ $plan->duration_days }} días</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 mb-1">Total a pagar</p>
                    <span class="text-4xl font-black text-brand-neon">${{ number_format($plan->price, 2) }}</span>
                </div>
            </div>

            <!-- 💳 WIDGET AISLADO Y SEGURO DE WOMPI -->
            <div class="w-full flex justify-center bg-black/50 p-6 rounded-xl border border-neutral-800" x-ignore>
                <form action="{{ route('checkout.success') }}" method="GET">
                    <script 
                        src="https://wompisv.s3.amazonaws.com/widget/wompi.js"
                        data-wompi-appid="{{ config('services.wompi.app_id') }}"
                        data-wompi-amount="{{ number_format($plan->price, 2, '.', '') }}"
                        data-wompi-currency="USD"
                        data-wompi-idtransaccion="IRON-PLAN{{ $plan->id }}-{{ time() }}"
                        data-wompi-nombre="{{ ucwords(\Illuminate\Support\Str::slug($plan->name, ' ')) }}"
                        data-wompi-config-color="#b3e600" 
                        data-wompi-urlredireccion="{{ route('checkout.success', ['plan_id' => $plan->id]) }}">
                    </script>
                </form>
            </div>
            
            <p class="text-center text-xs text-gray-600 mt-6">
                🔒 Pagos procesados de forma segura mediante la pasarela encriptada de Wompi El Salvador.<br>
                <span class="text-neutral-800">App ID: {{ substr(config('services.wompi.app_id'), 0, 8) }}********</span>
            </p>
        </div>
    </div>
</x-app-layout>