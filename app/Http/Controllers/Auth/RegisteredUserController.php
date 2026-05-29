<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar la vista del Paso 1.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Procesar el Paso 1 y guardar en sesión temporal.
     */
    public function processStepOne(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Guardamos los datos validados en la sesión temporal
        $request->session()->put('register_step_1', $validated);

        return redirect()->route('register.step2');
    }

    /**
     * Mostrar la vista del Paso 2 (Solo si completó el paso 1).
     */
    public function createStepTwo(Request $request): View|RedirectResponse
    {
        // Si intenta entrar directo al paso 2 sin hacer el 1, lo regresamos
        if (!$request->session()->has('register_step_1')) {
            return redirect()->route('register');
        }

        return view('auth.register-step-2');
    }

    /**
     * Procesar el Paso 2, unir datos y crear el usuario en la BD.
     */
    public function store(Request $request): RedirectResponse
    {
        // Recuperar datos del paso 1
        $step1Data = $request->session()->get('register_step_1');

        if (!$step1Data) {
            return redirect()->route('register');
        }

        // Validar datos del paso 2
        $request->validate([
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:20'],
            'emergency_name' => ['required', 'string', 'max:255'],
            'emergency_phone' => ['required', 'string', 'max:20'],
        ]);

        // Crear el usuario real en la base de datos
        $user = User::create([
            'name' => $step1Data['name'],
            'email' => $step1Data['email'],
            'password' => Hash::make($step1Data['password']),
            'role' => 'member', // Rol por defecto
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'emergency_name' => $request->emergency_name,
            'emergency_phone' => $request->emergency_phone,
        ]);

        event(new Registered($user));

        // Autenticar (Logear) al usuario inmediatamente
        Auth::login($user);

        // Limpiar la sesión temporal del registro
        $request->session()->forget('register_step_1');

        return redirect(route('dashboard', absolute: false));
    }
}