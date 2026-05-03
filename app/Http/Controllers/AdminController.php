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
        $externos = UsuarioAspirante::where('estado_academico', 'externo')->count();
        $pendientes = UsuarioAspirante::where('estado_academico', 'pendiente')->count();

        $correosEnviados = Notificacion::where('estado_envio', 'enviado')->count();
        $correosFallidos = Notificacion::where('estado_envio', 'fallido')->count();

        $ultimosRegistros = UsuarioAspirante::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRegistros',
            'estudiantesActivos',
            'egresados',
            'externos',
            'pendientes',
            'correosEnviados',
            'correosFallidos',
            'ultimosRegistros'
        ));
    }

    public function listarAdmins()
    {
        $administradores = Administrador::orderBy('created_at', 'desc')->get();
        $adminActualId = Session::get('admin_id');

        return view('admin.administradores', compact('administradores', 'adminActualId'));
    }

    public function crearAdmin(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'min:2', 'max:150', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ0-9\s\-]+$/'],
            'correo' => 'required|email|max:150|unique:administradores,correo',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo debe contener letras y números.',
            'nombre.min' => 'El nombre debe tener mínimo 2 caracteres.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.unique' => 'Este correo ya está registrado como administrador.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
            'password_confirmation.same' => 'Las contraseñas no coinciden.',
        ]);

        $admin = Administrador::create([
            'nombre' => $request->nombre,
            'correo' => strtolower($request->correo),
            'password_hash' => Hash::make($request->password),
        ]);

        RegistroAuditoria::create([
            'tipo_evento' => 'crear_admin',
            'descripcion' => 'Administrador creado: ' . $admin->nombre . ' (' . $admin->correo . ')',
            'ip_address' => $request->ip(),
            'administrador_id' => Session::get('admin_id'),
        ]);

        return redirect()->route('admin.administradores')->with('success', 'Administrador creado exitosamente.');
    }

    public function eliminarAdmin(Request $request, $id)
    {
        if (Session::get('admin_id') == $id) {
            return redirect()->route('admin.administradores')->withErrors(['error' => 'No puede eliminarse a sí mismo.']);
        }

        if ($id == 1) {
            return redirect()->route('admin.administradores')->withErrors(['error' => 'El administrador principal no puede ser eliminado.']);
        }

        $admin = Administrador::findOrFail($id);
        RegistroAuditoria::where('administrador_id', $id)->update(['administrador_id' => null]);
        $nombreAdmin = $admin->nombre;
        $correoAdmin = $admin->correo;
        $admin->delete();

        RegistroAuditoria::create([
            'tipo_evento' => 'eliminar_admin',
            'descripcion' => 'Administrador eliminado: ' . $nombreAdmin . ' (' . $correoAdmin . ')',
            'ip_address' => $request->ip(),
            'administrador_id' => Session::get('admin_id'),
        ]);

        return redirect()->route('admin.administradores')->with('success', 'Administrador eliminado exitosamente.');
    }

    public function listarUsuarios(Request $request)
    {
        $query = UsuarioAspirante::query();

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->where(function ($q) use ($busqueda) {
                $q->where('primer_nombre', 'ilike', "%{$busqueda}%")
                  ->orWhere('primer_apellido', 'ilike', "%{$busqueda}%")
                  ->orWhere('numero_documento', 'ilike', "%{$busqueda}%")
                  ->orWhere('correo', 'ilike', "%{$busqueda}%");
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

        $usuarios = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());

        return view('admin.usuarios', compact('usuarios'));
    }

    public function verUsuario($id)
    {
        $usuario = UsuarioAspirante::with(['preguntaSeguridad', 'validaciones', 'notificaciones'])->findOrFail($id);

        return view('admin.usuario-detalle', compact('usuario'));
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
        $externos = (clone $query)->where('estado_academico', 'externo')->count();
        $pendientes = (clone $query)->where('estado_academico', 'pendiente')->count();
        $totalRegistros = $estudiantesActivos + $egresados + $externos + $pendientes;

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

        $validacionQuery = ValidacionAcademica::whereIn('usuario_id', $usuarioIds);

        $validadosItm = (clone $validacionQuery)->whereIn('resultado', ['estudiante_activo', 'egresado'])->count();
        $noPertenece = (clone $validacionQuery)->where('resultado', 'externo')->count();
        $pendientesVal = $totalRegistros - $validadosItm - $noPertenece;
        if ($pendientesVal < 0) $pendientesVal = 0;

        return view('admin.graficas', compact(
            'estudiantesActivos',
            'egresados',
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
}