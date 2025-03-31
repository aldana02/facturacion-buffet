<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/inactive', function () {
        return view('auth.inactive');
    })->name('inactive');
});
Route::post('/logout', function () {
    Auth::logout();
    return redirect('home');
})->name('logout');

Route::resource('productos', ProductoController::class);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index'); 
Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create'); 
Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store'); 
Route::get('/ventas/{venta}/edit', [VentaController::class, 'edit'])->name('ventas.edit'); 
Route::put('/ventas/{venta}', [VentaController::class, 'update'])->name('ventas.update'); 
Route::delete('/ventas/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy'); 
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');
Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
Route::post('/facturar-dia', [FacturaController::class, 'facturarDia'])->name('facturas.facturarDia');
Route::get('/mp/test', [App\Http\Controllers\MercadoPagoController::class, 'test']);
Route::post('/facturas/seleccionadas', [FacturaController::class, 'facturarSeleccionadas'])->name('facturas.facturarSeleccionadas');