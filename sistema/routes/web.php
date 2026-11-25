<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('template/administrador');
// });

// Vista raíz del sistema: el dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

// Gestión
Route::resource('medicines', MedicineController::class)->except('show');
Route::resource('customers', CustomerController::class)->except('show');
// Una venta no se edita: se registra, se consulta (show) y, si hace falta, se anula (destroy)
Route::resource('sales', SaleController::class)->except(['edit', 'update']);

// Configuraciones
Route::resource('roles', RoleController::class)->except('show');
Route::resource('users', UserController::class)->except('show');
Route::resource('categories', CategoryController::class)->except('show');
