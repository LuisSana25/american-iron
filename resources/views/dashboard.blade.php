<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($latestSubscription && $isSubscriptionActive)
                <!-- ========================================================================= -->
                <!-- ESTADO 1: ATLETA ACTIVO (Credencial Digital Verde - image_1abec1.png)    -->
                <!-- ========================================================================= -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Tarjeta de Acceso Principal (Pase Digital) -->
                    <div class="lg:col-span-2 bg-[#141414] border border-brand-neon/30 rounded-3xl p-8 relative overflow-hidden shadow-2xl shadow-brand-neon/5 flex flex-col justify-between min-h-[320px]">
                        <div class="absolute top-0 right-0 bg-brand-neon text-black text-[10px] font-black uppercase tracking-widest px-5 py-1.5 rounded-bl-xl">
                            Acceso Autorizado
                        </div>
                        
                        <div>
                            <span class="text-xs font-bold text-brand-neon uppercase tracking-widest block mb-1">Membresía Activa</span>
                            <h2 class="text-3xl font-black text-white uppercase tracking-tight mb-4">{{ $latestSubscription->plan->name }}</h2>
                            
                            <div class="grid grid-cols-2 gap-4 max-w-sm text-sm">
                                <div>
                                    <span class="text-gray-500 block text-xs uppercase font-medium">Vence el:</span>
                                    <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($latestSubscription->expires_at)->format('d/m/Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500 block text-xs uppercase font-medium">Estado del Motor:</span>
                                    <span class="text-green-400 font-semibold flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span> Al día
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Código QR Simulado Minimalista -->
                        <div class="mt-8 pt-6 border-t border-neutral-900 flex items-center justify-between gap-6">
                            <div>
                                <span class="text-xs text-gray-500 font-mono block">MEMBER_ID: {{ sprintf('%05d', Auth::user()->id) }}</span>
                                <span class="text-xs text-gray-400 font-medium">Muestra este código frente al escáner de la entrada</span>
                            </div>
                            <div class="bg-white p-2.5 rounded-xl border border-neutral-200 shrink-0">
                                <svg class="w-14 h-14 text-black" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h6v6H3V3zm2 2v2h2V5H5zm8-2h6v6h-6V3zm2 2v2h2V5h-2zM3 15h6v6H3v-6zm2 2v2h2v-2H5zm13-2h3v2h-3v-3zm3 3h-3v3h3v-3zm-3 1h-2v2h2v-2zm-3-4h2v2h-2v-2zm2 2h2v2h-2v-2zm-4-2h2v2h-2v-2zm2 4h-2v2h2v-2zm-4-4h2v2h-2v-2zm-6-2h2v2H5V9zm14 0h2v2h-2V9z"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Columna Lateral Informativa -->
                    <div class="bg-[#141414] border border-neutral-900 rounded-3xl p-8 flex flex-col justify-between">
                        <div>
                            <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Información del Atleta</h4>
                            <div class="space-y-3 text-sm">
                                <p class="text-gray-400"><strong class="text-gray-500">Nombre:</strong> {{ Auth::user()->name }}</p>
                                <p class="text-gray-400"><strong class="text-gray-500">Email:</strong> {{ Auth::user()->email }}</p>
                                <p class="text-gray-400"><strong class="text-gray-500">Teléfono:</strong> {{ Auth::user()->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="text-xs text-gray-600 mt-6 pt-4 border-t border-neutral-900">
                            American Iron Gym System v1.1.0 • Impulsado por Laravel 11.
                        </div>
                    </div>

                </div>

            @elseif($latestSubscription)
                <!-- ========================================================================= -->
                <!-- ESTADO 2: ATLETA CON MEMBRESÍA VENCIDA / CANCELADA (Alerta Roja)          -->
                <!-- ========================================================================= -->
                <div class="bg-[#141414] border border-red-600/30 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 mb-8 shadow-xl shadow-red-950/5">
                    <div class="flex items-center gap-5">
                        <div class="p-3.5 bg-red-500/10 rounded-xl border border-red-500/20 text-red-500 shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-red-400 uppercase tracking-tight mb-1">Membresía Vencida</h3>
                            <p class="text-gray-400 text-sm max-w-xl">Tu pase de entrenamiento **({{ $latestSubscription->plan->name }})** expiró el pasado <span class="text-white font-bold">{{ \Carbon\Carbon::parse($latestSubscription->expires_at)->format('d/m/Y') }}</span>. Renueva tu suscripción para reactivar tu código QR y continuar con tus rutinas.</p>
                        </div>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="w-full md:w-auto text-center bg-red-600 hover:bg-red-700 text-white text-xs font-black uppercase tracking-wider px-6 py-3.5 rounded-xl transition duration-200 whitespace-nowrap">
                        Renovar Membresía &rarr;
                    </a>
                </div>

            @else
                <!-- ========================================================================= -->
                <!-- ESTADO 3: ATLETA COMPLETAMENTE NUEVO SIN REGISTROS (Alerta Amarilla)      -->
                <!-- ========================================================================= -->
                <div class="bg-[#141414] border border-yellow-600/30 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 mb-8 shadow-xl shadow-yellow-950/5">
                    <div class="flex items-center gap-5">
                        <div class="p-3.5 bg-yellow-500/10 rounded-xl border border-yellow-500/20 text-yellow-500 shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white uppercase tracking-tight mb-1">Membresía Inactiva</h3>
                            <p class="text-gray-400 text-sm max-w-xl">Tu cuenta no registra un pase de entrenamiento vigente en el sistema. Elige uno de nuestros planes para activar tu código QR y tener acceso instantáneo a las instalaciones.</p>
                        </div>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="w-full md:w-auto text-center bg-brand-neon hover:bg-[#b3e600] text-black text-xs font-black uppercase tracking-wider px-6 py-3.5 rounded-xl transition duration-200 whitespace-nowrap">
                        Elegir un Plan &rarr;
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>