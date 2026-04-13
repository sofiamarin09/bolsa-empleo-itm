<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreRegistroController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pre-registro', [PreRegistroController::class, 'create'])->name('pre-registro');
Route::post('/pre-registro', [PreRegistroController::class, 'store'])->name('pre-registro.store');
Route::get('/pre-registro/exito', [PreRegistroController::class, 'exito'])->name('pre-registro.exito');