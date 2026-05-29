<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-white mb-1">Crear una cuenta</h2>
        <p class="text-sm text-gray-400">Ingresa tus datos para crear tu cuenta</p>
    </div>

    <div class="flex justify-center items-center space-x-4 mb-10">
        <div class="flex items-center space-x-2 opacity-60">
            <div class="w-6 h-6 rounded-full bg-blue-900 flex items-center justify-center text-xs text-blue-300 font-bold">1</div>
            <span class="text-sm text-gray-400 font-medium">Información de<br>Cuenta</span>
        </div>
        <div class="w-8 border-t border-blue-900"></div>
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center text-xs text-white font-bold">2</div>
            <span class="text-sm text-blue-500 font-medium leading-tight">Información del<br>Miembro</span>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-5">
            <h3 class="text-md font-bold text-white uppercase tracking-wider">Información del Miembro</h3>
        </div>

        <div class="mb-5">
            <label for="birthdate" class="block text-sm font-medium text-white mb-1">Fecha de Nacimiento</label>
            <!-- Cambiamos type="text" a type="date" -->
            <input id="birthdate" type="date" name="birthdate" class="w-full bg-[#1c1c1c] border-transparent rounded-md text-white px-4 py-2 focus:border-brand-neon focus:ring-1 focus:ring-brand-neon transition" required />
        </div>

        <div class="mb-5">
            <label for="gender" class="block text-sm font-medium text-white mb-1">Género</label>
            <select id="gender" name="gender" class="w-full bg-[#1c1c1c] border-transparent rounded-md text-white px-4 py-2 focus:border-brand-neon focus:ring-1 focus:ring-brand-neon transition appearance-none">
                <option value="" disabled selected>Seleccionar Género</option>
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
                <option value="otro">Otro</option>
            </select>
        </div>

        <div class="mb-5">
            <label for="phone" class="block text-sm font-medium text-white mb-1">Número de Teléfono</label>
            <input id="phone" type="tel" name="phone" class="w-full bg-[#1c1c1c] border-transparent rounded-md text-white px-4 py-2 focus:border-brand-neon focus:ring-1 focus:ring-brand-neon transition" placeholder="Número de Teléfono" required />
        </div>

        <div class="mb-5">
            <label for="emergency_name" class="block text-sm font-medium text-white mb-1">Nombre del Contacto de Emergencia</label>
            <input id="emergency_name" type="text" name="emergency_name" class="w-full bg-[#1c1c1c] border-transparent rounded-md text-white px-4 py-2 focus:border-brand-neon focus:ring-1 focus:ring-brand-neon transition" placeholder="Nombre del Contacto de Emergencia" required />
        </div>

        <div class="mb-8">
            <label for="emergency_phone" class="block text-sm font-medium text-white mb-1">Teléfono del Contacto de Emergencia</label>
            <input id="emergency_phone" type="tel" name="emergency_phone" class="w-full bg-[#1c1c1c] border-transparent rounded-md text-white px-4 py-2 focus:border-brand-neon focus:ring-1 focus:ring-brand-neon transition" placeholder="Teléfono del Contacto de Emergencia" required />
        </div>

        <div class="flex items-center justify-between shadow-sm">
            <a href="/register" class="text-sm text-gray-400 hover:text-white font-medium transition duration-200">
                Anterior
            </a>

            <button type="submit" class="bg-brand-neon hover:bg-[#b3e600] text-black font-bold py-2 px-6 rounded-md transition duration-200">
                Crear cuenta
            </button>
        </div>

        <div class="mt-8 text-center text-sm text-gray-400">
            ¿Ya tienes una cuenta? 
            <a href="{{ route('login') }}" class="text-brand-neon hover:underline font-medium ml-1">
                Iniciar sesión
            </a>
        </div>
    </form>
</x-guest-layout>