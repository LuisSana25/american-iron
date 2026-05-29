@extends('layouts.admin')

@section('content')
<div x-data="{ 
    searchQuery: '{{ $search }}',
    statusFilter: '{{ $statusFilter }}',
    openFormModal: false,
    openProfileModal: false,
    openDeleteModal: false,
    isEdit: false,
    metodoPago: 'efectivo',
    
    formAction: '{{ route('admin.members.store') }}',
    deleteAction: '',

    formMember: { id: null, name: '', phone: '', email: '', plan_id: '{{ $plans->first()->id ?? '' }}' },
    activeMember: { id: null, name: '', phone: '', email: '', plan: '', status: '', joins: '', expire: '' },

    initCreate() {
        this.isEdit = false;
        this.formMember = { id: null, name: '', phone: '', email: '', plan_id: '{{ $plans->first()->id ?? '' }}' };
        this.formAction = '{{ route('admin.members.store') }}';
        this.metodoPago = 'efectivo';
        this.openFormModal = true;
    },
    initEdit(member) {
        this.isEdit = true;
        // Mapeamos los ID y estados reales recuperados de MariaDB hacia el formulario reactivo
        this.formMember = { 
            id: member.id, 
            name: member.name, 
            phone: member.phone, 
            email: member.email,
            plan_id: member.active_plan_id ? member.active_plan_id : '{{ $plans->first()->id ?? '' }}'
        };
        this.metodoPago = member.payment_method_current ? member.payment_method_current : 'efectivo';
        this.formAction = '/admin/members/' + member.id + '/update';
        this.openFormModal = true;
    },
    initView(member) {
        this.activeMember = { 
            id: member.id, 
            name: member.name, 
            phone: member.phone, 
            email: member.email, 
            plan: member.plan_name, 
            status: member.is_active ? 'Activo' : 'Vencido', 
            joins: member.join_date, 
            expire: member.expiration_date 
        };
        this.deleteAction = '/admin/members/' + member.id;
        this.openProfileModal = true;
    }
}">

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl text-xs flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-white uppercase tracking-tight mb-1">Control de Miembros</h1>
            <p class="text-sm text-gray-400">Panel administrativo enlazado a MariaDB con funciones de gestión y cobro en mostrador.</p>
        </div>
        <button @click="initCreate()" class="bg-brand-neon hover:bg-[#b3e600] text-black font-black text-xs uppercase tracking-wider py-2.5 px-5 rounded-xl transition duration-200 shadow-lg shadow-brand-neon/10">
            + Registrar Nuevo Miembro
        </button>
    </div>

    <div class="bg-[#141414] border border-neutral-900 rounded-xl p-4 mb-6 flex flex-col md:flex-row gap-4">
        <input x-model="searchQuery" @keydown.enter="window.location.href = '{{ route('admin.members') }}?search=' + searchQuery + '&status=' + statusFilter" type="text" class="bg-[#1c1c1c] border-transparent rounded-lg text-sm text-white px-4 py-2 w-full md:w-72 focus:border-brand-neon focus:ring-0 placeholder-gray-500" placeholder="Buscar y presionar Enter...">
        <select x-model="statusFilter" @change="window.location.href = '{{ route('admin.members') }}?search=' + searchQuery + '&status=' + statusFilter" class="bg-[#1c1c1c] border-transparent rounded-lg text-sm text-white px-4 py-2 focus:border-brand-neon focus:ring-0">
            <option value="Todos">Todos los estados</option>
            <option value="Activo">Activos</option>
            <option value="Vencido">Vencidos</option>
        </select>
    </div>

    <div class="bg-[#141414] border border-neutral-900 rounded-xl overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-neutral-900 bg-[#1a1a1a]/30 text-xs font-semibold uppercase text-gray-400">
                    <th class="px-6 py-3.5">Nombre</th>
                    <th class="px-6 py-3.5">Contacto</th>
                    <th class="px-6 py-3.5">Plan Activo</th>
                    <th class="px-6 py-3.5">Vencimiento</th>
                    <th class="px-6 py-3.5">Estado</th>
                    <th class="px-6 py-3.5 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-900 text-sm text-gray-300">
                @forelse($members as $member)
                    <tr class="hover:bg-[#1a1a1a]/10 transition">
                        <td class="px-6 py-4 font-bold text-white">{{ $member->name }} <span class="block text-[11px] text-gray-500 font-normal">{{ $member->email }}</span></td>
                        <td class="px-6 py-4 text-gray-400 font-medium">{{ $member->phone ?? 'N/A' }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-0.5 bg-neutral-950 border border-neutral-800 rounded text-xs text-gray-400">{{ $member->plan_name }}</span></td>
                        <td class="px-6 py-4 text-gray-400">{{ $member->expiration_date }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded text-xs font-bold {{ $member->is_active ? 'bg-green-950 text-green-400 border border-green-900/50' : 'bg-red-950 text-red-400 border border-red-900/50' }}">
                                {{ $member->is_active ? 'Activo' : 'Vencido' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-1 whitespace-nowrap">
                            <button @click="initView({{ json_encode($member) }})" class="text-xs bg-neutral-800 hover:bg-neutral-700 text-white px-2.5 py-1.5 rounded-lg transition font-medium">Ver</button>
                            <button @click="initEdit({{ json_encode($member) }})" class="text-xs bg-neutral-800 hover:bg-neutral-700 text-brand-neon px-2.5 py-1.5 rounded-lg transition font-medium">Editar</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">No se encontraron miembros registrados en el gimnasio.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- MODAL DE FORMULARIO DE ALTA Y EDICIÓN COMPLETA -->
    <div x-show="openFormModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" x-cloak>
        <div @click.away="openFormModal = false" class="bg-[#141414] border border-neutral-800 w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl">
            <div class="px-6 py-4 border-b border-neutral-800 flex justify-between items-center bg-[#1c1c1c]/40">
                <h2 class="text-sm font-black text-white uppercase tracking-wider" x-text="isEdit ? 'Editar Expediente y Membresía' : 'Matricular Atleta & Registrar Cobro'"></h2>
                <button @click="openFormModal = false" class="text-gray-400 hover:text-white text-xl">&times;</button>
            </div>
            
            <form :action="formAction" method="POST" class="p-6 space-y-4">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Nombre Completo</label>
                    <input x-model="formMember.name" name="name" type="text" class="w-full bg-[#1c1c1c] border-transparent rounded-lg text-white text-sm px-4 py-2 focus:border-brand-neon focus:ring-0" placeholder="Ej. Luis Fernando" required>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Teléfono</label>
                        <input x-model="formMember.phone" name="phone" type="text" class="w-full bg-[#1c1c1c] border-transparent rounded-lg text-white text-sm px-4 py-2 focus:border-brand-neon focus:ring-0" placeholder="7000-0000" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Correo Electrónico</label>
                        <input x-model="formMember.email" name="email" type="email" class="w-full bg-[#1c1c1c] border-transparent rounded-lg text-white text-sm px-4 py-2 focus:border-brand-neon focus:ring-0" placeholder="atleta@example.com" :disabled="isEdit" required>
                    </div>
                </div>

                <!-- SELECTOR DE PLAN (SIEMPRE DISPONIBLE) -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Membresía / Plan Asignado</label>
                    <select name="plan_id" x-model="formMember.plan_id" class="w-full bg-[#1c1c1c] border-transparent rounded-lg text-white text-sm px-4 py-2 focus:border-brand-neon focus:ring-0">
                        @foreach($plans as $p)
                            <option value="{{ $p->id }}">{{ $p->name }} (${{ number_format($p->price, 2) }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- BLOQUE DE COBRO EN CAJA (SIEMPRE DISPONIBLE) -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Método de Cobro en Caja</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center justify-between p-3 rounded-lg border bg-[#1c1c1c] cursor-pointer transition select-none" :class="metodoPago === 'efectivo' ? 'border-brand-neon text-white' : 'border-neutral-800 text-gray-400'">
                            <span class="text-xs font-bold flex items-center gap-2">Efectivo</span>
                            <input type="radio" name="payment_method" value="efectivo" x-model="metodoPago" class="hidden">
                            <div class="w-3.5 h-3.5 rounded-full border flex items-center justify-center" :class="metodoPago === 'efectivo' ? 'border-brand-neon' : 'border-neutral-600'">
                                <div class="w-2 h-2 rounded-full bg-brand-neon" x-show="metodoPago === 'efectivo'"></div>
                            </div>
                        </label>
                        <label class="flex items-center justify-between p-3 rounded-lg border bg-[#1c1c1c] cursor-pointer transition select-none" :class="metodoPago === 'tarjeta' ? 'border-brand-neon text-white' : 'border-neutral-800 text-gray-400'">
                            <span class="text-xs font-bold flex items-center gap-2">Tarjeta (POS Físico)</span>
                            <input type="radio" name="payment_method" value="tarjeta" x-model="metodoPago" class="hidden">
                            <div class="w-3.5 h-3.5 rounded-full border flex items-center justify-center" :class="metodoPago === 'tarjeta' ? 'border-brand-neon' : 'border-neutral-600'">
                                <div class="w-2 h-2 rounded-full bg-brand-neon" x-show="metodoPago === 'tarjeta'"></div>
                            </div>
                        </label>
                    </div>
                </div>
                
                <div x-show="metodoPago === 'tarjeta'" x-transition class="bg-[#1c1c1c]/50 p-3 rounded-lg border border-neutral-900">
                    <label class="block text-[9px] font-bold text-gray-500 uppercase mb-1">Nº Referencia del POS (Voucher Banco)</label>
                    <input name="pos_reference" type="text" class="w-full bg-[#141414] border-transparent rounded text-white text-xs px-3 py-1.5 focus:border-brand-neon focus:ring-0" placeholder="Ej. 001245">
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-neutral-900">
                    <button type="button" @click="openFormModal = false" class="text-xs text-gray-400 hover:text-white px-4 py-2 font-semibold">Cancelar</button>
                    <button type="submit" class="bg-brand-neon hover:bg-[#b3e600] text-black font-black text-xs uppercase tracking-wider px-5 py-2.5 rounded-xl transition" x-text="isEdit ? 'Actualizar Todo' : 'Completar Matrícula'"></button>
                </div>
            </form>
        </div>
    </div>

    <!-- FICHA DEL ATLETA MODAL -->
    <div x-show="openProfileModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" x-cloak>
        <div @click.away="openProfileModal = false" class="bg-[#141414] border border-neutral-800 w-full max-w-md rounded-2xl overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-neutral-800 flex justify-between items-start bg-[#1c1c1c]/50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-brand-neon text-black font-black flex items-center justify-center text-sm" x-text="activeMember.name ? activeMember.name.split(' ').map(n => n[0]).join('').substring(0,2) : ''"></div>
                    <div>
                        <h3 class="text-md font-bold text-white uppercase tracking-tight" x-text="activeMember.name"></h3>
                        <span class="text-[10px] text-gray-500 block font-medium mt-0.5" x-text="'Matriculado en: ' + activeMember.joins"></span>
                    </div>
                </div>
                <button @click="openProfileModal = false" class="text-gray-400 hover:text-white text-xl">&times;</button>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4 border-b border-neutral-800/60 pb-4">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-gray-500 block mb-0.5">Teléfono</span>
                        <span class="text-xs text-white font-medium" x-text="activeMember.phone ? activeMember.phone : 'N/A'"></span>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold text-gray-500 block mb-0.5">Correo</span>
                        <span class="text-xs text-white font-medium truncate block" x-text="activeMember.email"></span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 items-center">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-gray-500 block mb-0.5">Plan Asignado</span>
                        <span class="px-2 py-0.5 bg-neutral-800 border border-neutral-700 rounded text-[11px] font-semibold text-gray-300 inline-block" x-text="activeMember.plan"></span>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold text-gray-500 block mb-0.5">Vencimiento</span>
                        <span class="text-xs text-white font-semibold" x-text="activeMember.expire"></span>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-[#1c1c1c]/30 border-t border-neutral-800 flex justify-between items-center">
                <button @click="openDeleteModal = true; openProfileModal = false" class="text-xs font-bold text-red-500 hover:text-red-400">
                    Eliminar Atleta
                </button>
                <button @click="openProfileModal = false" class="bg-neutral-800 hover:bg-neutral-700 text-white text-xs font-bold py-2 px-4 rounded-lg transition">
                    Cerrar Ficha
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL DE ELIMINACIÓN -->
    <div x-show="openDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm" x-cloak>
        <div class="bg-[#141414] border border-red-950 max-w-sm w-full rounded-xl p-6 text-center space-y-4 shadow-2xl">
            <div class="w-11 h-11 rounded-full bg-red-950/50 border border-red-900 text-red-500 flex items-center justify-center mx-auto text-sm font-bold">!</div>
            <h3 class="text-md font-bold text-white uppercase tracking-tight">¿Confirmas la baja permanente?</h3>
            <p class="text-xs text-gray-400">Esta acción removerá el expediente del atleta y sus registros históricos asociados de MariaDB de manera definitiva.</p>
            
            <form :action="deleteAction" method="POST" class="flex gap-3 justify-center pt-2">
                @csrf
                @method('DELETE')
                <button type="button" @click="openDeleteModal = false" class="bg-neutral-850 hover:bg-neutral-800 text-white text-xs font-bold py-2 px-4 rounded-lg transition">Cancelar</button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded-lg transition">Sí, Eliminar de DB</button>
            </form>
        </div>
    </div>

</div>
@endsection