<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ITM Bolsa de empleo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; }

        .header { background: #1a3c6e; color: white; padding: 16px 40px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 18px; font-weight: 500; }
        .header-right { display: flex; align-items: center; gap: 16px; }
        .header-right span { font-size: 13px; opacity: 0.85; }
        .btn-logout { background: none; border: 1px solid rgba(255,255,255,0.4); color: white; padding: 6px 16px; border-radius: 6px; font-size: 13px; cursor: pointer; transition: background 0.2s; }
        .btn-logout:hover { background: rgba(255,255,255,0.1); }

        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }

        .welcome { margin-bottom: 28px; }
        .welcome h2 { color: #1a3c6e; font-size: 22px; font-weight: 600; margin-bottom: 4px; }
        .welcome p { color: #666; font-size: 14px; }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 32px; }
        .stat-card { background: white; border-radius: 10px; padding: 20px; border: 1px solid #e8e8e8; }
        .stat-card .label { font-size: 13px; color: #666; margin-bottom: 6px; }
        .stat-card .value { font-size: 28px; font-weight: 600; color: #1a3c6e; }
        .stat-card.activo .value { color: #065f46; }
        .stat-card.egresado .value { color: #0C447C; }
        .stat-card.externo .value { color: #854F0B; }
        .stat-card.pendiente .value { color: #666; }

        .section-title { font-size: 18px; font-weight: 600; color: #1a3c6e; margin-bottom: 16px; }

        .notif-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 32px; }
        .notif-card { background: white; border-radius: 10px; padding: 18px; border: 1px solid #e8e8e8; display: flex; align-items: center; gap: 14px; }
        .notif-icon { width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .notif-icon.success { background: #d1fae5; }
        .notif-icon.error { background: #fee2e2; }
        .notif-card .notif-label { font-size: 13px; color: #666; }
        .notif-card .notif-value { font-size: 22px; font-weight: 600; }
        .notif-card .notif-value.success { color: #065f46; }
        .notif-card .notif-value.error { color: #991b1b; }

        .table-card { background: white; border-radius: 10px; border: 1px solid #e8e8e8; overflow: hidden; }
        .table-card table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .table-card th { background: #1a3c6e; color: white; padding: 12px 16px; text-align: left; font-weight: 500; }
        .table-card td { padding: 12px 16px; border-bottom: 1px solid #f0f0f0; }
        .table-card tr:last-child td { border-bottom: none; }
        .table-card tr:hover { background: #f9f9f9; }

        .badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500; }
        .badge.activo { background: #d1fae5; color: #065f46; }
        .badge.egresado { background: #E6F1FB; color: #0C447C; }
        .badge.externo { background: #FAEEDA; color: #633806; }
        .badge.pendiente { background: #f1f1f1; color: #666; }

        .nav-links { display: flex; gap: 12px; margin-bottom: 28px; }
        .nav-link { padding: 8px 18px; border-radius: 6px; font-size: 13px; text-decoration: none; border: 1px solid #e8e8e8; color: #1a3c6e; background: white; transition: background 0.2s; }
        .nav-link:hover { background: #E6F1FB; }
        .nav-link.active { background: #1a3c6e; color: white; border-color: #1a3c6e; }

        .footer { background: #1a3c6e; color: white; text-align: center; padding: 20px; margin-top: 40px; }
        .footer p { font-size: 12px; opacity: 0.7; margin-bottom: 2px; }

        @media (max-width: 600px) {
            .header { padding: 14px 20px; flex-direction: column; gap: 10px; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .notif-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header class="header">
        <h1>ITM - Panel de administración</h1>
        <div class="header-right">
            <span>{{ Session::get('admin_nombre') }}</span>
            <form method="POST" action="{{ route('admin.logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar sesión</button>
            </form>
        </div>
    </header>

    <div class="container">

        <div class="welcome">
            <h2>Bienvenido, {{ Session::get('admin_nombre') }}</h2>
            <p>Resumen general del sistema de pre-registro de la Bolsa de Empleo.</p>
        </div>

        <div class="nav-links">
        <a href="{{ route('admin.dashboard') }}" class="nav-link active">Dashboard</a>
        <a href="{{ route('admin.usuarios') }}" class="nav-link">Usuarios</a>
        <a href="{{ route('admin.administradores') }}" class="nav-link">Administradores</a>
        <a href="{{ route('admin.graficas') }}" class="nav-link">Gráficas</a>
        </div>

        <h3 class="section-title">Estadísticas de registro</h3>
        <div class="stats-grid">
            <div class="stat-card">
                <p class="label">Total registros</p>
                <p class="value">{{ $totalRegistros }}</p>
            </div>
            <div class="stat-card activo">
                <p class="label">Estudiantes activos</p>
                <p class="value">{{ $estudiantesActivos }}</p>
            </div>
            <div class="stat-card egresado">
                <p class="label">Egresados</p>
                <p class="value">{{ $egresados }}</p>
            </div>
            <div class="stat-card externo">
                <p class="label">Usuarios externos</p>
                <p class="value">{{ $externos }}</p>
            </div>
            <div class="stat-card pendiente">
                <p class="label">Pendientes</p>
                <p class="value">{{ $pendientes }}</p>
            </div>
        </div>

        <h3 class="section-title">Notificaciones por correo</h3>
        <div class="notif-grid">
            <div class="notif-card">
                <div class="notif-icon success">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#065f46" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                </div>
                <div>
                    <p class="notif-label">Correos enviados</p>
                    <p class="notif-value success">{{ $correosEnviados }}</p>
                </div>
            </div>
            <div class="notif-card">
                <div class="notif-icon error">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#991b1b" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                </div>
                <div>
                    <p class="notif-label">Correos fallidos</p>
                    <p class="notif-value error">{{ $correosFallidos }}</p>
                </div>
            </div>
        </div>

        <h3 class="section-title">Últimos registros</h3>
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimosRegistros as $usuario)
                    <tr>
                        <td>{{ $usuario->numero_documento }}</td>
                        <td>{{ $usuario->primer_nombre }} {{ $usuario->primer_apellido }}</td>
                        <td>{{ $usuario->correo }}</td>
                        <td>
                            @if($usuario->estado_academico === 'estudiante_activo')
                                <span class="badge activo">Estudiante activo</span>
                            @elseif($usuario->estado_academico === 'egresado')
                                <span class="badge egresado">Egresado</span>
                            @elseif($usuario->estado_academico === 'externo')
                                <span class="badge externo">Externo</span>
                            @else
                                <span class="badge pendiente">Pendiente</span>
                            @endif
                        </td>
                        <td>{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999; padding: 24px;">No hay registros aún.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <footer class="footer">
        <p>Instituto Tecnológico Metropolitano &mdash; Programa de Egresados</p>
        <p>Campus Fraternidad &mdash; &copy; {{ date('Y') }}</p>
    </footer>

<script>
var tiempoInactividad;
function reiniciarTemporizador() {
    clearTimeout(tiempoInactividad);
    tiempoInactividad = setTimeout(function() {
        var overlay = document.createElement('div');
        overlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:9999;';
        var modal = document.createElement('div');
        modal.style.cssText = 'background:white;border-radius:10px;padding:30px 40px;text-align:center;max-width:400px;box-shadow:0 4px 20px rgba(0,0,0,0.15);';
        modal.innerHTML = '<h3 style="color:#1a3c6e;margin-bottom:10px;font-family:Segoe UI,sans-serif;">Sesión expirada</h3><p style="color:#555;font-size:14px;margin-bottom:20px;font-family:Segoe UI,sans-serif;">Su sesión ha expirado por inactividad.</p><button onclick="cerrarSesion()" style="background:#1a3c6e;color:white;border:none;padding:10px 30px;border-radius:6px;font-size:14px;cursor:pointer;font-family:Segoe UI,sans-serif;">Aceptar</button>';
        overlay.appendChild(modal);
        document.body.appendChild(overlay);
    }, 900000);
}
function cerrarSesion() {
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.logout") }}';
    var csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);
    document.body.appendChild(form);
    form.submit();
}
document.addEventListener('mousemove', reiniciarTemporizador);
document.addEventListener('keypress', reiniciarTemporizador);
document.addEventListener('click', reiniciarTemporizador);
document.addEventListener('scroll', reiniciarTemporizador);
reiniciarTemporizador();
</script>

</body>
</html>