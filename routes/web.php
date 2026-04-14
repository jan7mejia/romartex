<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RepuestoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Vendedor\VendedorController;
use App\Http\Controllers\Vendedor\VentaController;
use App\Http\Controllers\Vendedor\MarcaController; // Importado para la mejora de Marcas
use Illuminate\Support\Facades\Auth;

// 1. GESTIÓN DE ACCESO INICIAL
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->rol === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('vendedor.catalogo');
    }
    return redirect()->route('login');
});

// RUTAS PARA USUARIOS NO AUTENTICADOS (INVITADOS)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// RUTA DE LOGOUT
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');

// 2. RUTAS PROTEGIDAS (SOLO USUARIOS LOGUEADOS)
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // CATÁLOGO VENDEDOR
    Route::get('/catalogo', [VendedorController::class, 'index'])->name('vendedor.catalogo');

    // --- MEJORA: SECCIÓN DE MARCAS ---
    Route::get('/vendedor/marcas', [MarcaController::class, 'index'])->name('vendedor.marcas');

    // --- MEJORA: PROCESAMIENTO DE VENTAS DIRECTAS ---
    Route::post('/vendedor/confirmar-venta', [VentaController::class, 'store'])->name('vendedor.venta.store');

    // 3. RUTAS DE ADMIN (ROMARTEX)
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // CRUD Repuestos
        Route::get('/repuestos/{tipo}', [RepuestoController::class, 'index'])->name('admin.repuestos.index');
        Route::get('/repuestos/{tipo}/nuevo', [RepuestoController::class, 'create'])->name('admin.repuestos.create');
        Route::post('/repuestos/{tipo}/guardar', [RepuestoController::class, 'store'])->name('admin.repuestos.store');
        
        Route::get('/repuestos/{tipo}/{id}/editar', [RepuestoController::class, 'edit'])->name('admin.repuestos.edit');
        Route::put('/repuestos/{tipo}/{id}/actualizar', [RepuestoController::class, 'update'])->name('admin.repuestos.update');
        
        Route::delete('/repuestos/{id}', [RepuestoController::class, 'destroy'])->name('admin.repuestos.destroy');

        Route::get('/ventas/{id}', [AdminController::class, 'verVentaDetalle'])->name('admin.ventas.detalle');

        // --- GESTIÓN DE USUARIOS ---
        Route::get('/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');
        Route::get('/usuarios/nuevo', [UserController::class, 'create'])->name('admin.usuarios.create');
        Route::post('/usuarios/guardar', [UserController::class, 'store'])->name('admin.usuarios.store');
        
        Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('admin.usuarios.edit');
        Route::put('/usuarios/{id}/actualizar', [UserController::class, 'update'])->name('admin.usuarios.update');
        
        Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('admin.usuarios.destroy');
    });
});