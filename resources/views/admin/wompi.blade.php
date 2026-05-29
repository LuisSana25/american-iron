@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Encabezado con Botón de Descarga Real -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black uppercase tracking-tight text-white">Conciliación de Pagos</h1>
            <p class="text-xs text-gray-500 mt-1">Auditoría de pasarela Wompi SV e ingresos consolidados de caja.</p>
        </div>
        <div class="flex items-center gap-3 self-end sm:self-auto">
            <!-- Botón Conectado a la Ruta Contable -->
            <a href="{{ route('admin.wompi.export') }}" class="flex items-center gap-2 bg-brand-neon hover:bg-[#b3e600] text-black text-xs font-black uppercase tracking-wider px-4 py-2.5 rounded-xl transition duration-200 shadow-lg shadow-brand-neon/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Descargar Reporte CSV
            </a>
            
            <div class="text-xs font-mono text-purple-400 bg-purple-950/20 border border-purple-900/30 px-3 py-1.5 rounded-lg hidden md:block">
                Pasarela: Wompi El Salvador API v1
            </div>
        </div>
    </div>

    <!-- Grid de Métricas de Caja Compuesta -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Canal 1: Wompi Online -->
        <div class="bg-[#141414] border border-neutral-900 rounded-2xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full blur-xl"></div>
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] uppercase font-black tracking-widest text-purple-400">Pasarela Web (Online)</span>
                <span class="p-2 bg-purple-500/10 border border-purple-500/20 rounded-xl text-purple-400 font-mono text-[10px] font-black">API</span>
            </div>
            <h3 class="text-2xl font-black text-white tracking-tight">${{ number_format($wompiRevenue, 2) }}</h3>
            <p class="text-[10px] text-gray-500 mt-2">Transacciones liquidadas con tarjeta de crédito/débito.</p>
        </div>

        <!-- Canal 2: POS Mostrador -->
        <div class="bg-[#141414] border border-neutral-900 rounded-2xl p-6 shadow-xl">
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] uppercase font-black tracking-widest text-gray-400">Tarjeta POS (Mostrador)</span>
                <span class="p-2 bg-blue-500/10 border border-blue-500/20 rounded-xl text-blue-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                </span>
            </div>
            <h3 class="text-2xl font-black text-white tracking-tight">${{ number_format($posRevenue, 2) }}</h3>
            <p class="text-[10px] text-gray-500 mt-2">Vouchers cobrados físicamente en recepción.</p>
        </div>

        <!-- Canal 3: Efectivo -->
        <div class="bg-[#141414] border border-neutral-900 rounded-2xl p-6 shadow-xl">
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] uppercase font-black tracking-widest text-gray-400">Efectivo en Caja</span>
                <span class="p-2 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </span>
            </div>
            <h3 class="text-2xl font-black text-white tracking-tight">${{ number_format($cashRevenue, 2) }}</h3>
            <p class="text-[10px] text-gray-500 mt-2">Dinero físico auditado e ingresado en caja fuerte.</p>
        </div>

    </div>

    <!-- Libro de Transacciones Digitales -->
    <div class="bg-[#141414] border border-neutral-900 rounded-2xl overflow-hidden shadow-xl">
        <div class="p-5 border-b border-neutral-900 bg-[#1c1c1c]/30">
            <h4 class="text-sm font-bold text-white uppercase tracking-wider">Libro de Transacciones Wompi SV</h4>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-neutral-900 text-[10px] uppercase font-black text-gray-500 tracking-wider bg-[#0c0c0c]/40">
                        <th class="p-4">Atleta</th>
                        <th class="p-4">Plan Adquirido</th>
                        <th class="p-4">ID Transacción Enlace Banco</th>
                        <th class="p-4">Monto Neto</th>
                        <th class="p-4">Estatus Web</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-neutral-900 text-gray-300">
                    @forelse($wompiPayments as $p)
                        <tr class="hover:bg-[#1c1c1c]/30 transition">
                            <td class="p-4 font-bold text-white">{{ $p->user->name }}</td>
                            <td class="p-4 text-gray-400">{{ $p->subscription->plan->name ?? 'Plan Base' }}</td>
                            <td class="p-4 font-mono text-purple-400 tracking-wide select-all text-[11px]">{{ $p->wompi_transaction_id }}</td>
                            <td class="p-4 font-black text-white">${{ number_format($p->amount, 2) }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 bg-green-500/10 border border-green-500/20 text-green-400 font-bold rounded text-[10px] uppercase tracking-wide">
                                    Aprobada
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-gray-500 font-medium italic">
                                No se registran cobros mediante pasarela digital en línea todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection