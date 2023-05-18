<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Vendedores;
use App\Http\Livewire\Productos;
use App\Http\Livewire\Factura;
use App\Http\Livewire\Detalle;
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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/vendedores', Vendedores::class)->name('vendedores');
Route::get('/productos', Productos::class)->name('productos');
Route::get('/factura', Factura::class)->name('factura');
Route::get('/detalle', Detalle::class)->name('detalle');