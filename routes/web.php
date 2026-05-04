<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreRegistroController;
use App\Exports\UsuariosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pre-registro', [PreRegistroController::class, 'create'])->name('pre-registro');
Route::post('/pre-registro', [PreRegistroController::class, 'store'])->name('pre-registro.store');
Route::get('/pre-registro/exito', [PreRegistroController::class, 'exito'])->name('pre-registro.exito');

Route::get('/api/departamentos/{pais_id}', function ($pais_id) {
    $departamentos = \App\Models\Departamento::where('pais_id', $pais_id)
        ->orderBy('nombre')
        ->get(['id', 'nombre']);
    return response()->json($departamentos);
});
 
Route::get('/api/municipios/{departamento_id}', function ($departamento_id) {
    $municipios = \App\Models\Municipio::where('departamento_id', $departamento_id)
        ->orderBy('nombre')
        ->get(['id', 'nombre']);
    return response()->json($municipios);
});
 
Route::get('/api/paises', function () {
    $paises = \App\Models\Pais::orderBy('nombre')->get(['id', 'nombre']);
    return response()->json($paises);
});

Route::get('/admin/login', [AdminLoginController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/usuarios', [AdminController::class, 'listarUsuarios'])->name('admin.usuarios');
    Route::get('/admin/usuarios/{id}', [AdminController::class, 'verUsuario'])->name('admin.usuario.detalle');
    Route::get('/admin/administradores', [AdminController::class, 'listarAdmins'])->name('admin.administradores');
    Route::post('/admin/administradores', [AdminController::class, 'crearAdmin'])->name('admin.administradores.crear');
    Route::delete('/admin/administradores/{id}', [AdminController::class, 'eliminarAdmin'])->name('admin.administradores.eliminar');
    Route::get('/admin/graficas', [AdminController::class, 'graficas'])->name('admin.graficas');
    Route::get('/exportar-excel', function (Illuminate\Http\Request $request) {
        $estado = $request->query('estado');
        $fechaDesde = $request->query('fecha_desde');
        $fechaHasta = $request->query('fecha_hasta');

        if (is_array($estado)) {
            $estado = implode(',', $estado);
        }

        $nombreArchivo = 'usuarios_itm_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(
            new UsuariosExport($estado, $fechaDesde, $fechaHasta),
            $nombreArchivo
        );
    })->name('exportar.excel');
});