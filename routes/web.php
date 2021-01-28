<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VeiculosController;
use App\Http\Controllers\DisponibilidadeController;

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* ROTAS PARA AUTH LARAVEL SANCTUM */
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

/* ROTAS PARA AUTH TESTE */
Route::middleware(['auth:sanctum', 'verified'])->get('/home', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

/* ROTAS PARA USUÁRIO */
Route::middleware(['auth:sanctum', 'verified'])->get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios');
Route::middleware(['auth:sanctum', 'verified'])->get('/usuarios/edit/{id}', [UsuariosController::class, 'edit'])->name('usuarios.edit');
Route::middleware(['auth:sanctum', 'verified'])->put('/usuarios/edit/{id}', [UsuariosController::class, 'update'])->name('usuarios.edit');
Route::middleware(['auth:sanctum', 'verified'])->get('/usuarios/create', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::middleware(['auth:sanctum', 'verified'])->post('/usuarios/create', [UsuariosController::class, 'insert'])->name('usuarios.create');
Route::middleware(['auth:sanctum', 'verified'])->get('/usuarios/delete/{id}', [UsuariosController::class, 'delete'])->name('usuarios.delete');

/* ROTAS PARA VEICULOS */
Route::middleware(['auth:sanctum', 'verified'])->get('/veiculos', [VeiculosController::class, 'index'])->name('veiculos');
Route::middleware(['auth:sanctum', 'verified'])->get('/veiculos/edit/{id}', [VeiculosController::class, 'edit'])->name('veiculos.edit');
Route::middleware(['auth:sanctum', 'verified'])->put('/veiculos/edit/{id}', [VeiculosController::class, 'update'])->name('veiculos.edit');
Route::middleware(['auth:sanctum', 'verified'])->get('/veiculos/create', [VeiculosController::class, 'create'])->name('veiculos.create');
Route::middleware(['auth:sanctum', 'verified'])->post('/veiculos/create', [VeiculosController::class, 'insert'])->name('veiculos.create');
Route::middleware(['auth:sanctum', 'verified'])->get('/veiculos/delete/{id}', [VeiculosController::class, 'delete'])->name('veiculos.delete');

/* ROTAS PARA RESERVAS */
Route::middleware(['auth:sanctum', 'verified'])->get('/reservas', [ReservasController::class, 'index'])->name('reservas');
Route::middleware(['auth:sanctum', 'verified'])->get('/reservas/edit/{id}', [ReservasController::class, 'edit'])->name('reservas.edit');
Route::middleware(['auth:sanctum', 'verified'])->put('/reservas/edit/{id}', [ReservasController::class, 'update'])->name('reservas.edit');
Route::middleware(['auth:sanctum', 'verified'])->get('/reservas/create', [ReservasController::class, 'create'])->name('reservas.create');
Route::middleware(['auth:sanctum', 'verified'])->post('/reservas/create', [ReservasController::class, 'insert'])->name('reservas.create');
Route::middleware(['auth:sanctum', 'verified'])->get('/reservas/delete/{id}', [ReservasController::class, 'delete'])->name('reservas.delete');

/* ROTAS PARA RELATÓRIO DE DISPONIBILIDADE */
Route::middleware(['auth:sanctum', 'verified'])->get('/disponibilidade', [DisponibilidadeController::class, 'index'])->name('disponibilidade');
Route::middleware(['auth:sanctum', 'verified'])->get('/disponibilidade/{id}/{mes}', [DisponibilidadeController::class, 'filter'])->name('disponibilidade.filter');