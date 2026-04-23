<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreRegistroController;
use App\Exports\UsuariosExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pre-registro', [PreRegistroController::class, 'create'])->name('pre-registro');
Route::post('/pre-registro', [PreRegistroController::class, 'store'])->name('pre-registro.store');
Route::get('/pre-registro/exito', [PreRegistroController::class, 'exito'])->name('pre-registro.exito');
Route::get('/exportar-excel', function (Illuminate\Http\Request $request) {
    $estado = $request->query('estado');
    $fechaDesde = $request->query('fecha_desde');
    $fechaHasta = $request->query('fecha_hasta');

    $nombreArchivo = 'usuarios_itm_' . date('Y-m-d_His') . '.xlsx';

    return Excel::download(
        new UsuariosExport($estado, $fechaDesde, $fechaHasta),
        $nombreArchivo
    );
})->name('exportar.excel');