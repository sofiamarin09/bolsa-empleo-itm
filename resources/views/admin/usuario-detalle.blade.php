<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detalle de usuario - ITM Bolsa de empleo</title>
<style>

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; }
 
        .header { background: #1a3c6e; color: white; padding: 16px 40px; display: flex; justify-content: space-between; align-items: center; }

        .header h1 { font-size: 18px; font-weight: 500; }

        .header-right { display: flex; align-items: center; gap: 16px; }

        .header-right span { font-size: 13px; opacity: 0.85; }

        .btn-logout { background: none; border: 1px solid rgba(255,255,255,0.4); color: white; padding: 6px 16px; border-radius: 6px; font-size: 13px; cursor: pointer; }

        .btn-logout:hover { background: rgba(255,255,255,0.1); }
 
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
 
        .back-link { display: inline-flex; align-items: center; gap: 6px; color: #1a3c6e; text-decoration: none; font-size: 13px; margin-bottom: 20px; }

        .back-link:hover { text-decoration: underline; }
 
        .user-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }

        .user-header h2 { color: #1a3c6e; font-size: 22px; font-weight: 600; }
 
        .badge { display: inline-block; padding: 6px 16px; border-radius: 14px; font-size: 13px; font-weight: 500; }

        .badge.activo { background: #d1fae5; color: #065f46; }

        .badge.egresado { background: #E6F1FB; color: #0C447C; }

        .badge.externo { background: #FAEEDA; color: #633806; }

        .badge.pendiente { background: #f1f1f1; color: #666; }
 
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
 
        .card { background: white; border-radius: 10px; padding: 24px; border: 1px solid #e8e8e8; }

        .card h3 { color: #1a3c6e; font-size: 15px; font-weight: 600; margin-bottom: 16px; }
 
        .field-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .field { margin-bottom: 4px; }

        .field .label { font-size: 11px; color: #999; margin-bottom: 2px; }

        .field .value { font-size: 13px; color: #333; font-weight: 500; }
 
        .status-item { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }

        .status-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

        .status-dot.success { background: #065f46; }

        .status-dot.error { background: #e53e3e; }

        .status-dot.pending { background: #e8a820; }

        .status-text { font-size: 13px; color: #333; }

        .status-meta { font-size: 11px; color: #999; margin-top: 2px; }
 
        .footer { background: #1a3c6e; color: white; text-align: center; padding: 20px; margin-top: 40px; }

        .footer p { font-size: 12px; opacity: 0.7; margin-bottom: 2px; }
 
        @media (max-width: 768px) {

            .header { padding: 14px 20px; flex-direction: column; gap: 10px; }

            .detail-grid { grid-template-columns: 1fr; }

            .field-grid { grid-template-columns: 1fr; }

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
 
        <a href="{{ route('admin.usuarios') }}" class="back-link">← Volver al listado</a>
 
        <div class="user-header">
<h2>{{ $usuario->primer_nombre }} {{ $usuario->segundo_nombre ?? '' }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido ?? '' }}</h2>

            @if($usuario->estado_academico === 'estudiante_activo')
<span class="badge activo">Estudiante activo</span>

            @elseif($usuario->estado_academico === 'egresado')
<span class="badge egresado">Egresado</span>

            @elseif($usuario->estado_academico === 'externo')
<span class="badge externo">Externo</span>

            @else
<span class="badge pendiente">Pendiente</span>

            @endif
</div>
 
        <div class="detail-grid">
 
            <div class="card">
<h3>Datos personales</h3>
<div class="field-grid">
<div class="field">
<p class="label">Tipo de documento</p>
<p class="value">

                            @if($usuario->tipo_documento === 'cedula_ciudadania') Cédula de ciudadanía

                            @elseif($usuario->tipo_documento === 'tarjeta_identidad') Tarjeta de identidad

                            @else Documento nacional @endif
</p>
</div>
<div class="field">
<p class="label">Número de documento</p>
<p class="value">{{ $usuario->numero_documento }}</p>
</div>
<div class="field">
<p class="label">Primer nombre</p>
<p class="value">{{ $usuario->primer_nombre }}</p>
</div>
<div class="field">
<p class="label">Segundo nombre</p>
<p class="value">{{ $usuario->segundo_nombre ?? 'N/A' }}</p>
</div>
<div class="field">
<p class="label">Primer apellido</p>
<p class="value">{{ $usuario->primer_apellido }}</p>
</div>
<div class="field">
<p class="label">Segundo apellido</p>
<p class="value">{{ $usuario->segundo_apellido ?? 'N/A' }}</p>
</div>
<div class="field">
<p class="label">Fecha de nacimiento</p>
<p class="value">{{ $usuario->fecha_nacimiento->format('d/m/Y') }}</p>
</div>
<div class="field">
<p class="label">Sexo</p>
<p class="value">{{ ucfirst($usuario->sexo) }}</p>
</div>
</div>
</div>
 
            <div class="card">
<h3>Contacto y ubicación</h3>
<div class="field">
<p class="label">Correo electrónico</p>
<p class="value">{{ $usuario->correo }}</p>
</div>
<div class="field" style="margin-top: 12px;">
<p class="label">Teléfono celular</p>
<p class="value">{{ $usuario->telefono_celular }}</p>
</div>
<div class="field-grid" style="margin-top: 12px;">
<div class="field">
<p class="label">País</p>
<p class="value">{{ $usuario->pais }}</p>
</div>
<div class="field">
<p class="label">Departamento</p>
<p class="value">{{ $usuario->departamento }}</p>
</div>
<div class="field">
<p class="label">Municipio</p>
<p class="value">{{ $usuario->municipio }}</p>
</div>
</div>
<div style="border-top: 1px solid #f0f0f0; margin-top: 16px; padding-top: 14px;">
<div class="field">
<p class="label">Pregunta de seguridad</p>
<p class="value">{{ $usuario->preguntaSeguridad->pregunta ?? 'N/A' }}</p>
</div>
</div>
<div style="border-top: 1px solid #f0f0f0; margin-top: 16px; padding-top: 14px;">
<div class="field">
<p class="label">Fecha de registro</p>
<p class="value">{{ $usuario->created_at->format('d/m/Y H:i') }}</p>
</div>
</div>
</div>
 
            <div class="card">
<h3>Validación académica</h3>

                @forelse($usuario->validaciones as $validacion)
<div class="status-item">
<div class="status-dot {{ $validacion->resultado === 'externo' ? 'error' : 'success' }}"></div>
<div>
<p class="status-text">{{ $validacion->detalle }}</p>
<p class="status-meta">Fuente: {{ $validacion->fuente }} — {{ $validacion->fecha_validacion ? \Carbon\Carbon::parse($validacion->fecha_validacion)->format('d/m/Y H:i') : 'N/A' }}</p>
</div>
</div>

                @empty
<p style="color: #999; font-size: 13px;">No se ha realizado validación académica.</p>

                @endforelse
</div>
 
            <div class="card">
<h3>Notificación por correo</h3>

                @forelse($usuario->notificaciones as $notificacion)
<div class="status-item">
<div class="status-dot {{ $notificacion->estado_envio === 'enviado' ? 'success' : ($notificacion->estado_envio === 'fallido' ? 'error' : 'pending') }}"></div>
<div>
<p class="status-text">

                            @if($notificacion->estado_envio === 'enviado') Correo enviado exitosamente

                            @elseif($notificacion->estado_envio === 'fallido') El envío del correo falló

                            @else Correo pendiente de envío @endif
</p>
<p class="status-meta">Tipo: {{ $notificacion->tipo_notificacion }} — {{ $notificacion->created_at->format('d/m/Y H:i') }}</p>

                        @if($notificacion->fecha_envio)
<p class="status-meta">Enviado: {{ $notificacion->fecha_envio->format('d/m/Y H:i') }}</p>

                        @endif
</div>
</div>

                @empty
<p style="color: #999; font-size: 13px;">No se han enviado notificaciones.</p>

                @endforelse
</div>
 
        </div>
 
    </div>
 
    <footer class="footer">
<p>Instituto Tecnológico Metropolitano &mdash; Oficina de Egresados</p>
<p>Campus Fraternidad &mdash; &copy; {{ date('Y') }}</p>
</footer>
 
</body>
</html>
 