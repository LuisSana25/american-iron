<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Traemos todos los planes activos de la base de datos
    $plans = \App\Models\Plan::all(); 
    return view('welcome', compact('plans')); // Cambia 'welcome' por el nombre exacto de tu archivo Blade
});


// Catálogo de planes (Acceso público)
Route::get('/plans', function () {
    return view('plans');
})->name('plans');

// 2. GRUPO PROTEGIDO: Solo atletas logeados pueden acceder a estas secciones
Route::middleware('auth')->group(function () {
    
    // Panel de Control del Miembro con Verificación de 3 Estados (Activo, Vencido o Nuevo)
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // 1. Jalamos la última membresía registrada en MariaDB (sea activa o vencida)
        $latestSubscription = $user->subscriptions()
            ->with('plan') // Trae los datos del plan amarrado
            ->latest()     // Prioriza el ID más alto (el ciclo más reciente)
            ->first();

        // 2. Evaluamos bajo lógica estricta si está realmente activa y vigente hoy
        $isSubscriptionActive = $latestSubscription && 
                                $latestSubscription->status === 'active' && 
                                $latestSubscription->expires_at >= now()->toDateString();

        // 3. Enviamos las nuevas variables directo al Blade de alta fidelidad
        return view('dashboard', compact('latestSubscription', 'isSubscriptionActive'));
    })->name('dashboard');

    // Rutas de Configuración de Perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- CONEXIÓN REAL DE LA PASARELA WOMPI ---
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/{id}/pay', [\App\Http\Controllers\CheckoutController::class, 'pay'])->name('checkout.pay');
});

// Grupo de Rutas de UI para la Administración
Route::prefix('admin')->middleware('auth')->group(function () {
    
    // Conexión dinámica real
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    
    // Rutas para gestión de miembros y acceso 
    Route::get('/members', [AdminController::class, 'members'])->name('admin.members');
    Route::post('/members', [AdminController::class, 'storeMember'])->name('admin.members.store');
    Route::post('/members/{id}/update', [AdminController::class, 'updateMember'])->name('admin.members.update');
    Route::delete('/members/{id}', [AdminController::class, 'destroyMember'])->name('admin.members.destroy');
    Route::get('/access', [AdminController::class, 'accessIndex'])->name('admin.access');
    Route::post('/access/scan', [AdminController::class, 'scanQr'])->name('admin.access.scan');
    Route::get('/wompi/export', [AdminController::class, 'exportSales'])->name('admin.wompi.export');
    Route::get('/wompi', [AdminController::class, 'wompiIndex'])->name('admin.wompi');
});

require __DIR__.'/auth.php';