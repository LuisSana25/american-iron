@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black uppercase tracking-tight text-white">Vista General</h1>
            <p class="text-xs text-gray-500 mt-1">Métricas clave e ingresos consolidados de American Iron.</p>
        </div>
        <div class="text-xs font-mono text-brand-neon bg-[#141414] border border-neutral-800 px-3 py-1.5 rounded-lg">
            Sincronizado: {{ date('d/m/Y H:i') }}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-[#141414] border border-neutral-900 rounded-2xl p-6 shadow-xl shadow-black/20">
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] uppercase font-black tracking-widest text-gray-500">Caja Total (Wompi)</span>
                <span class="p-2 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <h3 class="text-3xl font-black text-white tracking-tight">${{ number_format($totalRevenue, 2) }}</h3>
            <p class="text-[10px] text-gray-400 mt-2 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span> Depósitos reales en USD
            </p>
        </div>

        <div class="bg-[#141414] border border-neutral-900 rounded-2xl p-6 shadow-xl shadow-black/20">
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] uppercase font-black tracking-widest text-gray-500">Atletas Activos</span>
                <span class="p-2 bg-brand-neon/10 border border-brand-neon/20 rounded-xl text-brand-neon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </span>
            </div>
            <h3 class="text-3xl font-black text-white tracking-tight">{{ $activeMembersCount }}</h3>
            <p class="text-[10px] text-gray-400 mt-2">Pases vigentes autorizados en puerta</p>
        </div>

        <div class="bg-[#141414] border border-neutral-900 rounded-2xl p-6 shadow-xl shadow-black/20">
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] uppercase font-black tracking-widest text-gray-500">Atletas Registrados</span>
                <span class="p-2 bg-purple-500/10 border border-purple-500/20 rounded-xl text-purple-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </span>
            </div>
            <h3 class="text-3xl font-black text-white tracking-tight">{{ $totalMembersCount }}</h3>
            <p class="text-[10px] text-gray-400 mt-2">Cuentas creadas en la aplicación</p>
        </div>

    </div>

    <div class="bg-[#141414] border border-neutral-900 rounded-2xl overflow-hidden shadow-xl shadow-black/10">
        <div class="p-5 border-b border-neutral-900 bg-[#1c1c1c]/30">
            <h4 class="text-sm font-bold text-white uppercase tracking-wider">Últimos Pagos Recibidos</h4>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-neutral-900 text-[10px] uppercase font-black text-gray-500 tracking-wider bg-[#0c0c0c]/40">
                        <th class="p-4">Atleta</th>
                        <th class="p-4">Plan Comprado</th>
                        <th class="p-4">Monto</th>
                        <th class="p-4">ID Transacción Wompi</th>
                        <th class="p-4">Fecha de Pago</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-neutral-900 text-gray-300">
                    @forelse($recentPayments as $payment)
                        <tr class="hover:bg-[#1c1c1c]/30 transition">
                            <td class="p-4 font-semibold text-white">{{ $payment->user->name }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 bg-neutral-950 border border-neutral-800 rounded text-[11px] text-gray-400">
                                    {{ $payment->subscription->plan->name ?? 'Plan Personalizado' }}
                                </span>
                            </td>
                            <td class="p-4 text-green-400 font-bold">${{ number_format($payment->amount, 2) }}</td>
                            <td class="p-4 font-mono text-purple-400 text-[11px]">{{ $payment->wompi_transaction_id }}</td>
                            <td class="p-4 text-gray-500">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500 font-medium">
                                No se registran cobros aprobados en el sistema todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection