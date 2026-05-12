<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Usuarios - ITM Bolsa de empleo</title>
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
 
        .nav-links { display: flex; gap: 12px; margin-bottom: 28px; }

        .nav-link { padding: 8px 18px; border-radius: 6px; font-size: 13px; text-decoration: none; border: 1px solid #e8e8e8; color: #1a3c6e; background: white; }

        .nav-link:hover { background: #E6F1FB; }

        .nav-link.active { background: #1a3c6e; color: white; border-color: #1a3c6e; }
 
        .filtros-card { background: white; border-radius: 10px; padding: 20px; border: 1px solid #e8e8e8; margin-bottom: 20px; }

        .filtros-card h3 { color: #1a3c6e; font-size: 15px; font-weight: 600; margin-bottom: 14px; }

        .filtros-grid { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 12px; margin-bottom: 14px; }

        .filtro-group label { font-size: 12px; color: #666; display: block; margin-bottom: 4px; }

        .filtro-group input, .filtro-group select {

            width: 100%;

            padding: 9px 12px;

            border: 1px solid #ccc;

            border-radius: 6px;

            font-size: 13px;

            font-family: 'Segoe UI', sans-serif;

        }

        .filtro-group input:focus, .filtro-group select:focus { outline: none; border-color: #2d6ab8; }

        .filtros-actions { display: flex; gap: 10px; }

        .btn-buscar { background: #1a3c6e; color: white; padding: 9px 20px; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; }

        .btn-buscar:hover { background: #15325a; }

        .btn-limpiar { background: white; color: #666; padding: 9px 20px; border: 1px solid #ccc; border-radius: 6px; font-size: 13px; cursor: pointer; text-decoration: none; }

        .btn-limpiar:hover { background: #f5f5f5; }

        .btn-excel { background: white; color: #065f46; padding: 9px 20px; border: 1px solid #065f46; border-radius: 6px; font-size: 13px; cursor: pointer; text-decoration: none; font-weight: 600; }

        .btn-excel:hover { background: #d1fae5; }
 
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
 
        .btn-detalle { color: #1a3c6e; text-decoration: none; font-size: 13px; font-weight: 500; }

        .btn-detalle:hover { text-decoration: underline; }
 
        .paginacion { display: flex; justify-content: space-between; align-items: center; padding: 14px 16px; border-top: 1px solid #f0f0f0; font-size: 13px; color: #666; }

        .paginacion-links { display: flex; gap: 4px; }

        .paginacion-links a, .paginacion-links span {

            padding: 6px 12px;

            border: 1px solid #e0e0e0;

            border-radius: 4px;

            font-size: 12px;

            text-decoration: none;

            color: #1a3c6e;

        }

        .paginacion-links span.current { background: #1a3c6e; color: white; border-color: #1a3c6e; }

        .paginacion-links a:hover { background: #E6F1FB; }
 
        .empty-state { text-align: center; color: #999; padding: 40px; font-size: 14px; }
 
        .spe-check { width: 20px; height: 20px; border: 2px solid #ccc; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; margin: 0 auto; transition: all 0.2s; }

        .spe-check.checked { background: #059669; border-color: #059669; }

        .spe-check:hover { border-color: #059669; }
 
        .footer { background: #1a3c6e; color: white; text-align: center; padding: 20px; margin-top: 40px; }

        .footer p { font-size: 12px; opacity: 0.7; margin-bottom: 2px; }
 
        @media (max-width: 768px) {

            .header { padding: 14px 20px; flex-direction: column; gap: 10px; }

            .filtros-grid { grid-template-columns: 1fr 1fr; }

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
 
        <div class="nav-links">
<a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
<a href="{{ route('admin.usuarios') }}" class="nav-link active">Usuarios</a>
<a href="{{ route('admin.administradores') }}" class="nav-link">Administradores</a>
<a href="{{ route('admin.graficas') }}" class="nav-link">Gráficas</a>
<a href="{{ route('admin.importar') }}" class="nav-link">Importar Excel</a>
</div>
 
        <div class="filtros-card">
<h3>Filtros de búsqueda</h3>
<form method="GET" action="{{ route('admin.usuarios') }}">
<div class="filtros-grid">
<div class="filtro-group">
<label>Buscar por nombre o documento</label>
<input type="text" name="busqueda" value="{{ request('busqueda') }}" placeholder="Buscar...">
</div>
<div class="filtro-group">
<label>Tipo de usuario ITM</label>
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px 12px; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px; background: white;">
<label style="font-size: 12px; font-weight: 400; display: flex; align-items: center; gap: 5px; cursor: pointer; margin: 0; white-space: nowrap;">
<input type="checkbox" name="estado[]" value="estudiante_activo" style="width: 14px; height: 14px;" {{ is_array(request('estado')) && in_array('estudiante_activo', request('estado')) ? 'checked' : '' }}>

                                Activo
</label>
<label style="font-size: 12px; font-weight: 400; display: flex; align-items: center; gap: 5px; cursor: pointer; margin: 0; white-space: nowrap;">
<input type="checkbox" name="estado[]" value="egresado" style="width: 14px; height: 14px;" {{ is_array(request('estado')) && in_array('egresado', request('estado')) ? 'checked' : '' }}>

                                Egresado
</label>
<label style="font-size: 12px; font-weight: 400; display: flex; align-items: center; gap: 5px; cursor: pointer; margin: 0; white-space: nowrap;">
<input type="checkbox" name="estado[]" value="externo" style="width: 14px; height: 14px;" {{ is_array(request('estado')) && in_array('externo', request('estado')) ? 'checked' : '' }}>

                                Externo
</label>
<label style="font-size: 12px; font-weight: 400; display: flex; align-items: center; gap: 5px; cursor: pointer; margin: 0; white-space: nowrap;">
<input type="checkbox" name="estado[]" value="pendiente" style="width: 14px; height: 14px;" {{ is_array(request('estado')) && in_array('pendiente', request('estado')) ? 'checked' : '' }}>

                                Pendiente
</label>
</div>
</div>
<div class="filtro-group">
<label>Fecha desde</label>
<input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}">
</div>
<div class="filtro-group">
<label>Fecha hasta</label>
<input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
</div>
</div>
<div class="filtros-grid">
<div class="filtro-group">
<label>Gestión SPE</label>
<select name="gestion_spe">
<option value="">Todos</option>
<option value="gestionado" {{ request('gestion_spe') == 'gestionado' ? 'selected' : '' }}>Gestionados</option>
<option value="pendiente" {{ request('gestion_spe') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
</select>
</div>
<div class="filtro-group"></div>
<div class="filtro-group"></div>
<div class="filtro-group"></div>
</div>
<div class="filtros-actions">
<button type="submit" class="btn-buscar">Buscar</button>
<a href="{{ route('admin.usuarios') }}" class="btn-limpiar">Limpiar filtros</a>
<a href="#" class="btn-excel" onclick="exportarExcel()">Exportar Excel</a>
</div>
</form>
</div>
 
        <div class="table-card">
<table>
<thead>
<tr>
<th style="width: 50px; text-align: center;">SPE</th>
<th>Documento</th>
<th>Nombre</th>
<th>Correo</th>
<th>Tipo de usuario ITM</th>
<th>Gestión</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>

                    @forelse($usuarios as $usuario)
<tr style="{{ $usuario->gestionado_spe ? 'background: #f0fdf4;' : '' }}">
<td style="text-align: center;">
<div class="spe-check {{ $usuario->gestionado_spe ? 'checked' : '' }}"

                                 onclick="toggleSpe({{ $usuario->id }}, this)"

                                 title="{{ $usuario->gestionado_spe ? 'Gestionado por ' . $usuario->gestionado_por . ' - ' . ($usuario->fecha_gestion_spe ? $usuario->fecha_gestion_spe->format('d/m/Y H:i') : '') : 'Marcar como gestionado' }}">

                                @if($usuario->gestionado_spe)
<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>

                                @endif
</div>
</td>
<td>{{ $usuario->numero_documento }}</td>
<td>{{ $usuario->primer_nombre }} {{ $usuario->primer_apellido }}</td>
<td>{{ $usuario->correo }}</td>
<td>

                            @if($usuario->estado_academico === 'estudiante_activo')
<span class="badge activo">Estudiante activo</span>

                            @elseif($usuario->estado_academico === 'egresado')
<span class="badge egresado">Egresado</span>

                            @elseif($usuario->estado_academico === 'egresado_activo')
<span class="badge egresado">Egresado</span> <span class="badge activo">Activo</span>

                            @elseif($usuario->estado_academico === 'externo')
<span class="badge externo">Externo</span>

                            @else
<span class="badge pendiente">Pendiente</span>

                            @endif
</td>
<td>

                            @if($usuario->gestionado_spe)
<span style="font-size: 12px; color: #059669; font-weight: 500;">Gestionado</span><br>
<span style="font-size: 11px; color: #999;">{{ $usuario->gestionado_por }} - {{ $usuario->fecha_gestion_spe ? $usuario->fecha_gestion_spe->format('d/m/Y') : '' }}</span>

                            @else
<span style="font-size: 12px; color: #EF9F27; font-weight: 500;">Pendiente</span>

                            @endif
</td>
<td><a href="{{ route('admin.usuario.detalle', $usuario->id) }}" class="btn-detalle">Ver detalle</a></td>
</tr>

                    @empty
<tr>
<td colspan="7" class="empty-state">No se encontraron registros.</td>
</tr>

                    @endforelse
</tbody>
</table>
 
            @if($usuarios->hasPages())
<div class="paginacion">
<span>Mostrando {{ $usuarios->firstItem() }}-{{ $usuarios->lastItem() }} de {{ $usuarios->total() }} registros</span>
<div class="paginacion-links">

                    @if($usuarios->onFirstPage())
<span style="opacity: 0.5;">Anterior</span>

                    @else
<a href="{{ $usuarios->previousPageUrl() }}">Anterior</a>

                    @endif
 
                    @foreach($usuarios->getUrlRange(1, $usuarios->lastPage()) as $page => $url)

                        @if($page == $usuarios->currentPage())
<span class="current">{{ $page }}</span>

                        @else
<a href="{{ $url }}">{{ $page }}</a>

                        @endif

                    @endforeach
 
                    @if($usuarios->hasMorePages())
<a href="{{ $usuarios->nextPageUrl() }}">Siguiente</a>

                    @else
<span style="opacity: 0.5;">Siguiente</span>

                    @endif
</div>
</div>

            @endif
</div>
 
    </div>
 
    <footer class="footer">
<p>Instituto Tecnológico Metropolitano &mdash; Programa de Egresados</p>
<p>Campus Fraternidad &mdash; &copy; {{ date('Y') }}</p>
</footer>
 
    <script>

    function exportarExcel() {

        var params = new URLSearchParams(window.location.search);

        var url = '{{ route("exportar.excel") }}?' + params.toString();

        window.location.href = url;

    }
</script>
 
    <script>

    function toggleSpe(id, el) {

        fetch('/admin/usuarios/' + id + '/gestionar-spe', {

            method: 'POST',

            headers: {

                'Content-Type': 'application/json',

                'X-CSRF-TOKEN': '{{ csrf_token() }}'

            }

        })

        .then(function(r) { return r.json(); })

        .then(function(data) {

            if (data.success) {

                var row = el.closest('tr');

                var gestionCol = row.querySelectorAll('td')[5];

                if (data.gestionado) {

                    el.classList.add('checked');

                    el.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>';

                    el.title = 'Gestionado por ' + data.admin + ' - ' + data.fecha;

                    row.style.background = '#f0fdf4';

                    gestionCol.innerHTML = '<span style="font-size: 12px; color: #059669; font-weight: 500;">Gestionado</span><br><span style="font-size: 11px; color: #999;">' + data.admin + ' - ' + data.fecha + '</span>';

                } else {

                    el.classList.remove('checked');

                    el.innerHTML = '';

                    el.title = 'Marcar como gestionado';

                    row.style.background = '';

                    gestionCol.innerHTML = '<span style="font-size: 12px; color: #EF9F27; font-weight: 500;">Pendiente</span>';

                }

            }

        });

    }
</script>
 
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

        }, 3600000);

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
 