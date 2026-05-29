@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <div class="lg:col-span-1 space-y-6">
        <div class="bg-[#141414] border border-neutral-900 rounded-2xl p-6 shadow-xl">
            <h2 class="text-sm font-black uppercase tracking-wider text-white mb-2">Simulador de Molinete</h2>
            <p class="text-xs text-gray-500 mb-6">Digita el número de MEMBER_ID para emular la lectura del escáner QR de la entrada principal.</p>

            <form method="POST" action="{{ route('admin.access.scan') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5">Código de Barras / QR (ID)</label>
                    <input type="number" name="member_id" autofocus placeholder="Ej. 2" required
                           class="w-full bg-[#1c1c1c] border border-neutral-800 text-center font-mono text-xl tracking-widest text-brand-neon rounded-xl py-3.5 focus:border-brand-neon focus:ring-0 transition">
                </div>
                <button type="submit" class="w-full bg-brand-neon hover:bg-[#b3e600] text-black text-xs font-black uppercase tracking-wider py-3.5 rounded-xl transition duration-200">
                    Efectuar Escaneo 
                </button>
            </form>
        </div>

        @if(session('grant'))
            <div class="bg-green-950/40 border-2 border-green-500 rounded-2xl p-6 text-center space-y-3 shadow-2xl shadow-green-950/20">
                <div class="w-12 h-12 bg-green-500 text-black font-black flex items-center justify-center rounded-full mx-auto text-lg animate-bounce">✓</div>
                <h3 class="text-md font-black uppercase tracking-tight text-green-400">Pase Autorizado</h3>
                <p class="text-xs text-gray-300 leading-relaxed">{{ session('grant') }}</p>
            </div>
        @endif

        @if(session('deny'))
            <div class="bg-red-950/40 border-2 border-red-500 rounded-2xl p-6 text-center space-y-3 shadow-2xl shadow-red-950/20">
                <div class="w-12 h-12 bg-red-500 text-white font-black flex items-center justify-center rounded-full mx-auto text-lg animate-pulse">✕</div>
                <h3 class="text-md font-black uppercase tracking-tight text-red-400">Pase Denegado</h3>
                <p class="text-xs text-gray-300 leading-relaxed">{{ session('deny') }}</p>
            </div>
        @endif
    </div>

    <div class="lg:col-span-2">
        <div class="bg-[#141414] border border-neutral-900 rounded-2xl overflow-hidden shadow-xl h-full flex flex-col justify-between">
            <div>
                <div class="p-5 border-b border-neutral-900 bg-[#1c1c1c]/30 flex justify-between items-center">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider">Historial de Accesos del Día</h4>
                    <span class="w-2 h-2 rounded-full bg-brand-neon animate-pulse"></span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-neutral-900 text-[10px] uppercase font-black text-gray-500 tracking-wider bg-[#0c0c0c]/40">
                                <th class="p-4">Atleta</th>
                                <th class="p-4">Identificador</th>
                                <th class="p-4">Estatus de Entrada</th>
                                <th class="p-4">Hora de Registro</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs divide-y divide-neutral-900 text-gray-300">
                            @forelse($logs as $log)
                                <tr class="hover:bg-[#1c1c1c]/30 transition">
                                    <td class="p-4 font-bold text-white">{{ $log->user->name ?? 'Usuario Removido' }}</td>
                                    <td class="p-4 font-mono text-gray-500">MEMBER_ID_{{ sprintf('%04d', $log->user_id) }}</td>
                                    <td class="p-4">
                                        @if($log->access_granted)
                                            <span class="text-green-400 font-bold flex items-center gap-1.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> Concedido
                                            </span>
                                        @else
                                            <span class="text-red-500 font-bold flex items-center gap-1.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Denegado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-gray-500">{{ $log->created_at->format('H:i:s A - d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-gray-500 font-medium italic">
                                        Ningún escaneo registrado en las últimas horas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="p-4 bg-[#0c0c0c]/50 border-t border-neutral-900 text-center text-[11px] text-gray-600 font-medium">
                Módulo de hardware unificado v1.0 • Listo para conexión física de relé.
            </div>
        </div>
    </div>

</div>
@endsection