<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComandoController;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Rutas para el controlador ComandoController
Route::middleware(['auth'])->group(function () {
    Route::get('/comando-control', [ComandoController::class, 'index'])->name('comando.index');
    Route::post('/comando-control', [ComandoController::class, 'store'])->name('comando.store');
});

// Ruta pública API para que el Arduino consulte el comando actual
Route::get('/api/comando', [ComandoController::class, 'getComando'])->name('comando.api');

require __DIR__ . '/auth.php';

use App\Http\Controllers\UsuarioController;

Route::prefix('usuarios')->name('usuarios.')->group(function () {
    Route::get('/', [UsuarioController::class, 'index'])->name('index');
    Route::get('/create', [UsuarioController::class, 'create'])->name('create'); // Crear usuario
    Route::post('/', [UsuarioController::class, 'store'])->name('store');         // Guardar usuario
    Route::get('/{usuario}/edit', [UsuarioController::class, 'edit'])->name('edit');  // Editar usuario
    Route::put('/{usuario}', [UsuarioController::class, 'update'])->name('update');  // Actualizar usuario
    Route::get('/eliminados', [UsuarioController::class, 'deleted'])->name('deleted');
    Route::patch('/{usuario}/bloqueo', [UsuarioController::class, 'toggleBloqueo'])->name('toggleBloqueo');
    Route::delete('/{usuario}', [UsuarioController::class, 'destroy'])->name('destroy');
    Route::patch('/{usuario}/restore', [UsuarioController::class, 'restore'])->name('restore');
});


use App\Http\Controllers\AscensorController;

Route::middleware(['auth'])->group(function () {
    Route::get('ascensores', [AscensorController::class, 'index'])->name('ascensores.index');
    Route::post('ascensores/update-access', [AscensorController::class, 'updateAccess'])->name('ascensores.updateAccess');
});
