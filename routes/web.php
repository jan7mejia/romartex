<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RepuestoController;

// 1. SIEMPRE AL LOGIN SI NO HAY SESIÓN
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');

// 2. RUTAS PROTEGIDAS
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/catalogo', function () {
        return view('catalogo');
    })->name('catalogo');

    // 3. RUTAS DE ADMIN (ROMARTEX)
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // CRUD Repuestos (Bendix, Inducidos, Reguladores)
        Route::get('/repuestos/{tipo}', [RepuestoController::class, 'index'])->name('admin.repuestos.index');
        Route::get('/repuestos/{tipo}/nuevo', [RepuestoController::class, 'create'])->name('admin.repuestos.create');
        Route::post('/repuestos/{tipo}/guardar', [RepuestoController::class, 'store'])->name('admin.repuestos.store');
        
        // Rutas de Edición y Actualización
        Route::get('/repuestos/{tipo}/{id}/editar', [RepuestoController::class, 'edit'])->name('admin.repuestos.edit');
        Route::put('/repuestos/{tipo}/{id}/actualizar', [RepuestoController::class, 'update'])->name('admin.repuestos.update');
        
        // Ruta de Eliminación
        Route::delete('/repuestos/{id}', [RepuestoController::class, 'destroy'])->name('admin.repuestos.destroy');

        // Ruta de ver detalles 
        Route::get('/ventas/{id}', [AdminController::class, 'verVentaDetalle'])->name('admin.ventas.detalle');
    });
});