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

            @php
                // Mapeo dinámico: Conectamos el ID del Plan de tu BD con el Enlace de Wompi
                $wompiUrl = '';
                if($plan->id == 1) $wompiUrl = 'https://s.wompi.sv/1580990mpf';
                if($plan->id == 2) $wompiUrl = 'https://s.wompi.sv/1580967JmX';  
                if($plan->id == 3) $wompiUrl = 'https://s.wompi.sv/1580969zK5';   
            @endphp

            <div class="w-full flex flex-col items-center bg-[#0a0a0a] p-6 rounded-xl border border-neutral-800" x-ignore>
                
                <div class="wompi_button_widget" data-url-pago="{{ $wompiUrl }}"></div>

                <script src="https://pagos.wompi.sv/js/wompi.pagos.js"></script>

            </div>
            
            <p class="text-center text-xs text-gray-600 mt-6">
                🔒 Pagos procesados de forma segura mediante la pasarela certificada de Wompi El Salvador.
            </p>
        </div>
    </div>
</x-app-layout>