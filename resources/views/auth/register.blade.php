<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-white mb-1">Crear una cuenta</h2>
        <p class="text-sm text-gray-400">Ingresa tus datos para crear tu cuenta</p>
    </div>

    <div class="flex justify-center items-center space-x-4 mb-10">
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center text-xs text-white font-bold">1</div>
            <span class="text-sm text-blue-500 font-medium">Información de<br>Cuenta</span>
        </div>
        <div class="w-8 border-t border-gray-700"></div>
        <div class="flex items-center space-x-2 opacity-50">
            <div class="w-6 h-6 rounded-full bg-gray-600 flex items-center justify-center text-xs text-white font-bold">2</div>
            <span class="text-sm text-gray-400 font-medium leading-tight">Información del<br>Miembro</span>
        </div>
    </div>

    <form method="POST" action="{{ route('register.step1.post') }}">
        @csrf
        
        <div class="mb-5">
            <label for="name" class="block text-sm font-medium text-white mb-1">Nombre</label>
            <input id="name" type="text" name="name" class="w-full bg-[#1c1c1c] border-transparent rounded-md text-white px-4 py-2 focus:border-brand-neon focus:ring-1 focus:ring-brand-neon transition" placeholder="Nombre completo" required autofocus autocomplete="name" />
        </div>

        <div class="mb-5">
            <label for="email" class="block text-sm font-medium text-white mb-1">Dirección de correo electrónico</label>
            <input id="email" type="email" name="email" class="w-full bg-[#1c1c1c] border-transparent rounded-md text-white px-4 py-2 focus:border-brand-neon focus:ring-1 focus:ring-brand-neon transition" placeholder="email@example.com" required autocomplete="username" />
        </div>

        <div class="mb-5 relative">
            <label for="password" class="block text-sm font-medium text-white mb-1">Contraseña</label>
            <input id="password" type="password" name="password" class="w-full bg-[#1c1c1c] border-transparent rounded-md text-white px-4 py-2 focus:border-brand-neon focus:ring-1 focus:ring-brand-neon transition" placeholder="Contraseña" required autocomplete="new-password" />
        </div>

        <div class="mb-8 relative">
            <label for="password_confirmation" class="block text-sm font-medium text-white mb-1">Confirmar contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="w-full bg-[#1c1c1c] border-transparent rounded-md text-white px-4 py-2 focus:border-brand-neon focus:ring-1 focus:ring-brand-neon transition" placeholder="Confirmar contraseña" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-brand-neon hover:bg-[#b3e600] text-black font-bold py-2 px-6 rounded-md transition duration-200">
                Siguiente
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