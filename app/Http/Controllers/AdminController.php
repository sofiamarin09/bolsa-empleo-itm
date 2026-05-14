<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioAspirante;
use App\Models\Notificacion;
use App\Models\ValidacionAcademica;
use App\Models\Administrador;
use App\Models\RegistroAuditoria;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalRegistros = UsuarioAspirante::count();
        $estudiantesActivos = UsuarioAspirante::where('estado_academico', 'estudiante_activo')->count();
        $egresados = UsuarioAspirante::where('estado_academico', 'egresado')->count();
        $egresadosActivos = UsuarioAspirante::where('estado_academico', 'egresado_activo')->count();
        $externos = UsuarioAspirante::where('estado_academico', 'externo')->count();
        $pendientes = UsuarioAspirante::where('estado_academico', 'pendiente')->count();

        $correosEnviados = Notificacion::where('estado_envio', 'enviado')->count();
        $correosFallidos = Notificacion::where('estado_envio', 'fallido')->count();

        $gestionadosSpe = UsuarioAspirante::where('gestionado_spe', true)->count();
        $pendientesSpe = UsuarioAspirante::where('gestionado_spe', false)->count();

        $ultimosRegistros = UsuarioAspirante::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRegistros',
            'estudiantesActivos',
            'egresados',
            'egresadosActivos',
            'externos',
            'pendientes',
            'correosEnviados',
            'correosFallidos',
            'gestionadosSpe',
            'pendientesSpe',
            'ultimosRegistros'
        ));
    }

    public function listarAdmins()
    {
        if (Session::get('admin_rol') !== 'superadmin') {
            return redirect()->route('admin.dashboard')
                ->withErrors(['error' => 'No tiene permisos para acceder a esta sección.']);
        }

        $administradores = Administrador::orderBy('created_at', 'desc')->get();
        $adminActualId = Session::get('admin_id');

        return view('admin.administradores', compact('administradores', 'adminActualId'));
    }

    public function crearAdmin(Request $request)
    {
        if (Session::get('admin_rol') !== 'superadmin') {
            return redirect()->route('admin.dashboard')
                ->withErrors(['error' => 'No tiene permisos para realizar esta acción.']);
        }

        $request->validate([
            'nombre' => ['required', 'string', 'min:2', 'max:150', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ0-9\s\-]+$/'],
            'correo' => ['required', 'email', 'max:150', 'unique:administradores,correo', 'regex:/^[a-zA-Z0-9._%+\-]+@itm\.edu\.co$/'],
            'rol' => 'required|in:superadmin,gestor',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo debe contener letras y números.',
            'nombre.min' => 'El nombre debe tener mínimo 2 caracteres.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.unique' => 'Este correo ya está registrado como administrador.',
            'correo.regex' => 'Solo se permiten correos institucionales @itm.edu.co.',
            'rol.required' => 'Seleccione un rol.',
            'rol.in' => 'El rol seleccionado no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
            'password_confirmation.same' => 'Las contraseñas no coinciden.',
        ]);

        if ($request->rol === 'superadmin') {
            $superAdminsActivos = Administrador::where('rol', 'superadmin')->where('activo', true)->count();
            if ($superAdminsActivos >= 2) {
                return back()->withErrors(['error' => 'Ya existen 2 SuperAdmins activos. Debe inactivar uno antes de crear otro.']);
            }
        }

        $admin = Administrador::create([
            'nombre'        => $request->nombre,
            'correo'        => strtolower($request->correo),
            'password_hash' => Hash::make($request->password),
            'rol'           => $request->rol,
            'activo'        => true,
        ]);

        RegistroAuditoria::create([
            'tipo_evento'      => 'crear_admin',
            'descripcion'      => 'Administrador creado: ' . $admin->nombre . ' (' . $admin->correo . ') - Rol: ' . $admin->rol,
            'ip_address'       => $request->ip(),
            'administrador_id' => Session::get('admin_id'),
        ]);

        return redirect()->route('admin.administradores')->with('success', 'Administrador creado exitosamente.');
    }

    public function toggleActivoAdmin(Request $request, $id)
    {
        if (Session::get('admin_rol') !== 'superadmin') {
            return redirect()->route('admin.dashboard')
                ->withErrors(['error' => 'No tiene permisos para realizar esta acción.']);
        }

        if (Session::get('admin_id') == $id) {
            return redirect()->route('admin.administradores')
                ->withErrors(['error' => 'No puede activar o desactivar su propia cuenta.']);
        }

        $admin = Administrador::findOrFail($id);
        $nuevoEstado = !$admin->activo;

        if ($nuevoEstado && $admin->rol === 'superadmin') {
            $superAdminsActivos = Administrador::where('rol', 'superadmin')->where('activo', true)->count();
            if ($superAdminsActivos >= 2) {
                return redirect()->route('admin.administradores')
                    ->withErrors(['error' => 'Ya existen 2 SuperAdmins activos. Debe inactivar uno antes de activar otro.']);
            }
        }

        $admin->update(['activo' => $nuevoEstado]);

        RegistroAuditoria::create([
            'tipo_evento'      => $nuevoEstado ? 'activar_admin' : 'inactivar_admin',
            'descripcion'      => ($nuevoEstado ? 'Administrador activado: ' : 'Administrador inactivado: ') . $admin->nombre . ' (' . $admin->correo . ')',
            'ip_address'       => $request->ip(),
            'administrador_id' => Session::get('admin_id'),
        ]);

        $rolLabel = $admin->rol === 'superadmin' ? 'SuperAdmin' : 'Gestor';
        $mensaje = $nuevoEstado ? "{$rolLabel} activado exitosamente." : "{$rolLabel} inactivado exitosamente.";
        return redirect()->route('admin.administradores')->with('success', $mensaje);
    }

    public function listarUsuarios(Request $request)
    {
        $query = UsuarioAspirante::query();

        if ($request->filled('pais')) {
            $pais = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]/', '', $request->pais);
            $query->where('pais', 'ilike', '%' . $pais . '%');
        }
        if ($request->filled('departamento')) {
            $departamento = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]/', '', $request->departamento);
            $query->where('departamento', 'ilike', '%' . $departamento . '%');
        }
        if ($request->filled('municipio')) {
            $municipio = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]/', '', $request->municipio);
            $query->where('municipio', 'ilike', '%' . $municipio . '%');
        }

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->where(function ($q) use ($busqueda) {
                $q->where('primer_nombre', 'ilike', "%{$busqueda}%")
                  ->orWhere('primer_apellido', 'ilike', "%{$busqueda}%")
                  ->orWhere('numero_documento', 'ilike', "%{$busqueda}%")
                  ->orWhere('correo', 'ilike', "%{$busqueda}%")
                  ->orWhereRaw("CONCAT(primer_nombre, ' ', primer_apellido) ilike ?", ["%{$busqueda}%"])
                  ->orWhereRaw("CONCAT(primer_nombre, ' ', segundo_apellido) ilike ?", ["%{$busqueda}%"])
                  ->orWhereRaw("CONCAT(primer_nombre, ' ', segundo_nombre, ' ', primer_apellido, ' ', segundo_apellido) ilike ?", ["%{$busqueda}%"]);
            });
        }

        if ($request->filled('estado')) {
            $estados = is_array($request->estado) ? $request->estado : [$request->estado];
            $query->whereIn('estado_academico', $estados);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        if ($request->filled('gestion_spe')) {
            if ($request->gestion_spe === 'gestionado') {
                $query->where('gestionado_spe', true);
            } elseif ($request->gestion_spe === 'pendiente') {
                $query->where('gestionado_spe', false);
            }
        }

        $usuarios = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());

        return view('admin.usuarios', compact('usuarios'));
    }

    public function verUsuario($id)
    {
        $usuario = UsuarioAspirante::with(['validaciones', 'notificaciones'])->findOrFail($id);

        return view('admin.usuario-detalle', compact('usuario'));
    }

    public function gestionarSpe(Request $request, $id)
    {
        $usuario = UsuarioAspirante::findOrFail($id);
        $nuevoEstado = !$usuario->gestionado_spe;

        $usuario->update([
            'gestionado_spe' => $nuevoEstado,
            'fecha_gestion_spe' => $nuevoEstado ? now() : null,
            'gestionado_por' => $nuevoEstado ? Session::get('admin_nombre') : null,
        ]);

        RegistroAuditoria::create([
            'tipo_evento' => $nuevoEstado ? 'gestion_spe' : 'revertir_gestion_spe',
            'descripcion' => ($nuevoEstado ? 'Marcado como gestionado: ' : 'Revertido gestión: ') . $usuario->numero_documento,
            'ip_address' => $request->ip(),
            'administrador_id' => Session::get('admin_id'),
        ]);

        return response()->json([
            'success' => true,
            'gestionado' => $nuevoEstado,
            'fecha' => $nuevoEstado ? now()->format('d/m/Y H:i') : null,
            'admin' => $nuevoEstado ? Session::get('admin_nombre') : null,
        ]);
    }

    public function graficas(Request $request)
    {
        $query = UsuarioAspirante::query();

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }
        if ($request->filled('estado')) {
            $query->where('estado_academico', $request->estado);
        }
        if ($request->filled('sexo')) {
            $query->where('sexo', $request->sexo);
        }
        if ($request->filled('tipo_documento')) {
            $query->where('tipo_documento', $request->tipo_documento);
        }
        if ($request->filled('pais')) {
            $query->where('pais', 'ilike', '%' . $request->pais . '%');
        }
        if ($request->filled('departamento')) {
            $query->where('departamento', 'ilike', '%' . $request->departamento . '%');
        }
        if ($request->filled('municipio')) {
            $query->where('municipio', 'ilike', '%' . $request->municipio . '%');
        }

        $usuarioIds = $query->pluck('id');

        $estudiantesActivos = (clone $query)->where('estado_academico', 'estudiante_activo')->count();
        $egresados = (clone $query)->where('estado_academico', 'egresado')->count();
        $egresadosActivos = (clone $query)->where('estado_academico', 'egresado_activo')->count();
        $externos = (clone $query)->where('estado_academico', 'externo')->count();
        $pendientes = (clone $query)->where('estado_academico', 'pendiente')->count();
        $totalRegistros = (clone $query)->count();

        $registrosPorMes = (clone $query)->selectRaw("TO_CHAR(created_at, 'YYYY-MM') as mes, COUNT(*) as total")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $notifQuery = Notificacion::whereIn('usuario_id', $usuarioIds);

        if ($request->filled('notificacion')) {
            $notifQuery->where('estado_envio', $request->notificacion);
        }

        $notifEnviadasPorMes = (clone $notifQuery)->where('estado_envio', 'enviado')
            ->selectRaw("TO_CHAR(created_at, 'YYYY-MM') as mes, COUNT(*) as total")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $notifFallidasPorMes = (clone $notifQuery)->where('estado_envio', 'fallido')
            ->selectRaw("TO_CHAR(created_at, 'YYYY-MM') as mes, COUNT(*) as total")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $validadosItm = $estudiantesActivos + $egresados + $egresadosActivos;
        $noPertenece = $externos;
        $pendientesVal = $pendientes;

        return view('admin.graficas', compact(
            'estudiantesActivos',
            'egresados',
            'egresadosActivos',
            'externos',
            'pendientes',
            'totalRegistros',
            'registrosPorMes',
            'notifEnviadasPorMes',
            'notifFallidasPorMes',
            'validadosItm',
            'noPertenece',
            'pendientesVal'
        ));
    }

    public function showImportar()
    {
        return view('admin.importar');
    }

    public function subirExcel(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls,csv|max:20480',
        ], [
            'archivo.required' => 'Debe seleccionar un archivo.',
            'archivo.mimes' => 'El archivo debe ser Excel (.xlsx, .xls) o CSV.',
            'archivo.max' => 'El archivo no debe superar los 20MB.',
        ]);

        $archivo = $request->file('archivo');
        $rutaTemporal = $archivo->store('importaciones', 'local');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/private/' . $rutaTemporal));
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [];
        foreach ($sheet->getRowIterator(1, 1) as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $valor = trim($cell->getValue());
                if ($valor) $headers[] = $valor;
            }
        }

        $totalFilas = $sheet->getHighestRow() - 1;

        $camposBD = [
            '' => '-- No importar --',
            'tipo_documento' => 'Tipo de documento',
            'numero_documento' => 'Número de documento',
            'correo' => 'Correo electrónico',
            'telefono' => 'Teléfono',
            'primer_nombre' => 'Primer nombre',
            'segundo_nombre' => 'Segundo nombre',
            'primer_apellido' => 'Primer apellido',
            'segundo_apellido' => 'Segundo apellido',
            'fecha_nacimiento' => 'Fecha de nacimiento',
            'sexo' => 'Sexo',
            'pais' => 'País',
            'departamento' => 'Departamento',
            'municipio' => 'Municipio',
            'estado_academico' => 'Tipo de usuario ITM',
        ];

        return view('admin.importar-mapeo', compact('headers', 'camposBD', 'rutaTemporal', 'totalFilas'));
    }

    public function ejecutarImportacion(Request $request)
    {
        $rutaTemporal = $request->input('ruta_temporal');
        $mapeo = $request->input('mapeo', []);

        $mapeoFiltrado = array_filter($mapeo, function ($campo) {
            return $campo !== '';
        });

        if (!in_array('numero_documento', $mapeoFiltrado)) {
            return back()->withErrors(['error' => 'Debe mapear al menos el campo "Número de documento".']);
        }

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/private/' . $rutaTemporal));
        $sheet = $spreadsheet->getActiveSheet();
        $filas = $sheet->toArray();
        $headers = array_shift($filas);

        $nuevos = 0;
        $duplicados = 0;
        $errores = 0;

        foreach (array_chunk($filas, 500) as $chunk) {
            foreach ($chunk as $fila) {
                try {
                    $datos = [];
                    foreach ($mapeoFiltrado as $indice => $campo) {
                        $valor = isset($fila[$indice]) ? trim($fila[$indice]) : null;
                        if ($valor !== null && $valor !== '') {
                            $datos[$campo] = $valor;
                        }
                    }

                    if (empty($datos['numero_documento'])) {
                        $errores++;
                        continue;
                    }

                    $existe = UsuarioAspirante::where('numero_documento', $datos['numero_documento'])->exists();
                    if ($existe) {
                        $duplicados++;
                        continue;
                    }

                    if (isset($datos['correo'])) {
                        $datos['correo'] = strtolower($datos['correo']);
                        $correoExiste = UsuarioAspirante::where('correo', $datos['correo'])->exists();
                        if ($correoExiste) {
                            $duplicados++;
                            continue;
                        }
                    }

                    if (isset($datos['tipo_documento'])) {
                        $datos['tipo_documento'] = match(mb_strtolower(trim($datos['tipo_documento']))) {
                            'cédula de ciudadanía', 'cedula de ciudadania', 'cc', 'cédula', 'cedula' => 'cedula_ciudadania',
                            'tarjeta de identidad', 'ti', 'tarjeta' => 'tarjeta_identidad',
                            'documento nacional', 'documento nacional de identificación', 'dni' => 'documento_nacional',
                            default => $datos['tipo_documento'],
                        };
                    }

                    if (isset($datos['estado_academico'])) {
                        $datos['estado_academico'] = match(mb_strtolower(trim($datos['estado_academico']))) {
                            'estudiante activo', 'activo', 'estudiante' => 'estudiante_activo',
                            'egresado', 'graduado' => 'egresado',
                            'externo', 'no pertenece', 'no pertenece al itm' => 'externo',
                            'egresado y activo', 'egresado activo', 'egresado y estudiante activo' => 'egresado_activo',
                            default => 'pendiente',
                        };
                    } else {
                        $datos['estado_academico'] = 'pendiente';
                    }

                    if (isset($datos['sexo'])) {
                        $datos['sexo'] = mb_strtolower(trim($datos['sexo']));
                    }

                    if (isset($datos['correo'])) {
                        $datos['correo'] = mb_strtolower(trim($datos['correo']));
                    }

                    if (isset($datos['telefono'])) {
                        $tel = $datos['telefono'];
                        // Convierte float/int de PhpSpreadsheet o notación científica a string limpio
                        if (is_float($tel) || is_int($tel)) {
                            $datos['telefono'] = (string)(int)$tel;
                        } elseif (is_string($tel) && preg_match('/^[\d.]+([eE][+\-]?\d+)?$/', $tel)) {
                            $datos['telefono'] = (string)(int)(float)$tel;
                        } else {
                            $datos['telefono'] = preg_replace('/[^\d+]/', '', $tel);
                        }
                    }

                    if (isset($datos['fecha_nacimiento']) && !empty($datos['fecha_nacimiento'])) {
                        $fecha = $datos['fecha_nacimiento'];
                        if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $fecha, $m)) {
                            $datos['fecha_nacimiento'] = $m[3] . '-' . str_pad($m[2], 2, '0', STR_PAD_LEFT) . '-' . str_pad($m[1], 2, '0', STR_PAD_LEFT);
                        } elseif (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/', $fecha, $m)) {
                            $datos['fecha_nacimiento'] = $m[3] . '-' . str_pad($m[2], 2, '0', STR_PAD_LEFT) . '-' . str_pad($m[1], 2, '0', STR_PAD_LEFT);
                        }
                    }

                    unset($datos['']);

                    $datos['acepta_terminos'] = true;
                    $datos['fecha_aceptacion_terminos'] = now();

                    UsuarioAspirante::create($datos);
                    $nuevos++;

                } catch (\Exception $e) {
                    $errores++;
                }
            }
        }

        if (file_exists(storage_path('app/private/' . $rutaTemporal))) {
            unlink(storage_path('app/private/' . $rutaTemporal));
        }

        RegistroAuditoria::create([
            'tipo_evento' => 'importacion_excel',
            'descripcion' => "Importación masiva: {$nuevos} nuevos, {$duplicados} duplicados, {$errores} errores.",
            'ip_address' => $request->ip(),
            'administrador_id' => Session::get('admin_id'),
        ]);

        return redirect()->route('admin.importar')->with('resultado', [
            'nuevos' => $nuevos,
            'duplicados' => $duplicados,
            'errores' => $errores,
        ]);
    }
}