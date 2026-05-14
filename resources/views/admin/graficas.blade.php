<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficas - ITM Bolsa de empleo</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"></script>
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
        .filtros-grid { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 12px; margin-bottom: 12px; }
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
        .btn-aplicar { background: #1a3c6e; color: white; padding: 9px 20px; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; }
        .btn-aplicar:hover { background: #15325a; }
        .btn-limpiar { background: white; color: #666; padding: 9px 20px; border: 1px solid #ccc; border-radius: 6px; font-size: 13px; cursor: pointer; text-decoration: none; }
        .btn-limpiar:hover { background: #f5f5f5; }

        .stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px; margin-bottom: 24px; }
        .stat-card { background: white; border-radius: 10px; padding: 18px; border: 1px solid #e8e8e8; text-align: center; }
        .stat-card .label { font-size: 12px; color: #666; margin-bottom: 6px; }
        .stat-card .value { font-size: 26px; font-weight: 600; }
        .stat-card .value.total { color: #1a3c6e; }
        .stat-card .value.activo { color: #065f46; }
        .stat-card .value.egresado { color: #0C447C; }
        .stat-card .value.egresado-activo { color: #6366f1; }
        .stat-card .value.externo { color: #854F0B; }

        .charts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .chart-card { background: white; border-radius: 10px; padding: 24px; border: 1px solid #e8e8e8; }
        .chart-card h3 { color: #1a3c6e; font-size: 15px; font-weight: 600; margin-bottom: 16px; }
        .chart-container { position: relative; height: 280px; }

        .footer { background: #1a3c6e; color: white; text-align: center; padding: 20px; margin-top: 40px; }
        .footer p { font-size: 12px; opacity: 0.7; margin-bottom: 2px; }

        @media (max-width: 768px) {
            .header { padding: 14px 20px; flex-direction: column; gap: 10px; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .charts-grid { grid-template-columns: 1fr; }
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
            <a href="{{ route('admin.usuarios') }}" class="nav-link">Usuarios</a>
            @if(Session::get('admin_rol') === 'superadmin')
            <a href="{{ route('admin.administradores') }}" class="nav-link">Administrador</a>
            @endif
            <a href="{{ route('admin.graficas') }}" class="nav-link active">Gráficas</a>
            <a href="{{ route('admin.importar') }}" class="nav-link">Importar Excel</a>
        </div>

        <div class="filtros-card">
            <h3>Filtros globales</h3>
            <form method="GET" action="{{ route('admin.graficas') }}">
                <div class="filtros-grid">
                    <div class="filtro-group">
                        <label>Fecha desde</label>
                        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="filtro-group">
                        <label>Fecha hasta</label>
                        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" max="{{ date('Y-m-d') }}">
                    </div>
                    <div class="filtro-group">
                        <label>Tipo de usuario ITM</label>
                        <select name="estado">
                            <option value="">Todos</option>
                            <option value="estudiante_activo" {{ request('estado') == 'estudiante_activo' ? 'selected' : '' }}>Estudiante activo</option>
                            <option value="egresado" {{ request('estado') == 'egresado' ? 'selected' : '' }}>Egresado</option>
                            <option value="egresado_activo" {{ request('estado') == 'egresado_activo' ? 'selected' : '' }}>Egresado y activo</option>
                            <option value="externo" {{ request('estado') == 'externo' ? 'selected' : '' }}>Externo</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        </select>
                    </div>
                    <div class="filtro-group">
                        <label>Sexo</label>
                        <select name="sexo">
                            <option value="">Todos</option>
                            <option value="masculino" {{ request('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="femenino" {{ request('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="intersexual" {{ request('sexo') == 'intersexual' ? 'selected' : '' }}>Intersexual</option>
                        </select>
                    </div>
                </div>
                <div class="filtros-grid">
                    <div class="filtro-group">
                        <label>Tipo de documento</label>
                        <select name="tipo_documento">
                            <option value="">Todos</option>
                            <option value="cedula_ciudadania" {{ request('tipo_documento') == 'cedula_ciudadania' ? 'selected' : '' }}>Cédula de ciudadanía</option>
                            <option value="tarjeta_identidad" {{ request('tipo_documento') == 'tarjeta_identidad' ? 'selected' : '' }}>Tarjeta de identidad</option>
                            <option value="documento_nacional" {{ request('tipo_documento') == 'documento_nacional' ? 'selected' : '' }}>Documento nacional</option>
                        </select>
                    </div>
                    <div class="filtro-group">
                        <label>País</label>
                        <select id="filtro-pais" name="pais" onchange="filtrarPais(this.value)">
                            <option value="">Todos</option>
                        </select>
                    </div>
                    <div class="filtro-group">
                        <label>Departamento</label>
                        <select id="filtro-departamento" name="departamento" onchange="filtrarDepartamento(this.value)">
                            <option value="">Todos</option>
                        </select>
                    </div>
                    <div class="filtro-group">
                        <label>Municipio</label>
                        <select id="filtro-municipio" name="municipio">
                            <option value="">Todos</option>
                        </select>
                    </div>
                </div>
                <div class="filtros-grid">
                    <div class="filtro-group">
                        <label>Notificaciones</label>
                        <select name="notificacion">
                            <option value="">Todas</option>
                            <option value="enviado" {{ request('notificacion') == 'enviado' ? 'selected' : '' }}>Enviadas</option>
                            <option value="fallido" {{ request('notificacion') == 'fallido' ? 'selected' : '' }}>Fallidas</option>
                            <option value="pendiente" {{ request('notificacion') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                        </select>
                    </div>
                    <div class="filtro-group"></div>
                    <div class="filtro-group"></div>
                    <div class="filtro-group"></div>
                </div>
                <div class="filtros-actions">
                    <button type="submit" class="btn-aplicar">Aplicar filtros</button>
                    <a href="{{ route('admin.graficas') }}" class="btn-limpiar">Limpiar filtros</a>
                </div>
            </form>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <p class="label">Total filtrado</p>
                <p class="value total">{{ $totalRegistros }}</p>
            </div>
            <div class="stat-card">
                <p class="label">Estudiantes activos</p>
                <p class="value activo">{{ $estudiantesActivos }}</p>
            </div>
            <div class="stat-card">
                <p class="label">Egresados</p>
                <p class="value egresado">{{ $egresados }}</p>
            </div>
            <div class="stat-card">
                <p class="label">Egresados activos</p>
                <p class="value egresado-activo">{{ $egresadosActivos }}</p>
            </div>
            <div class="stat-card">
                <p class="label">Externos</p>
                <p class="value externo">{{ $externos }}</p>
            </div>
        </div>

        <div class="charts-grid">

            <div class="chart-card">
                <h3>Distribución de registros</h3>
                <div class="chart-container">
                    <canvas id="chartTorta"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Estado de notificaciones</h3>
                <div class="chart-container">
                    <canvas id="chartNotificaciones"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Registros en el tiempo</h3>
                <div class="chart-container">
                    <canvas id="chartBarras"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Resumen de validaciones</h3>
                <div class="chart-container">
                    <canvas id="chartValidaciones"></canvas>
                </div>
            </div>

        </div>

    </div>

    <footer class="footer">
        <p>Instituto Tecnológico Metropolitano &mdash; Programa de Egresados</p>
        <p>Campus Fraternidad</p>
    </footer>

    <script>
    Chart.register(ChartDataLabels);

    var meses = {!! json_encode($registrosPorMes->pluck('mes')->toArray()) !!};
    var totalesMes = {!! json_encode($registrosPorMes->pluck('total')->toArray()) !!};

    var mesesNombres = meses.map(function(m) {
        var partes = m.split('-');
        var nombres = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        return nombres[parseInt(partes[1]) - 1] + ' ' + partes[0];
    });

    new Chart(document.getElementById('chartTorta'), {
        type: 'doughnut',
        data: {
            labels: ['Estudiantes activos', 'Egresados', 'Egresados activos', 'Externos', 'Pendientes'],
            datasets: [{
                data: [{{ $estudiantesActivos }}, {{ $egresados }}, {{ $egresadosActivos }}, {{ $externos }}, {{ $pendientes }}],
                backgroundColor: ['#059669', '#378ADD', '#6366f1', '#EF9F27', '#B4B2A9'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 16, usePointStyle: true, pointStyle: 'circle', font: { size: 12, family: 'Segoe UI' } }
                },
                datalabels: {
                    color: '#fff',
                    font: { weight: 'bold', size: 13 },
                    formatter: function(value) { return value > 0 ? value : ''; }
                }
            }
        }
    });

    var notifEnviadas = {!! json_encode($notifEnviadasPorMes->pluck('total')->toArray()) !!};
    var notifEnviadasMeses = {!! json_encode($notifEnviadasPorMes->pluck('mes')->toArray()) !!};
    var notifFallidas = {!! json_encode($notifFallidasPorMes->pluck('total')->toArray()) !!};
    var notifFallidasMeses = {!! json_encode($notifFallidasPorMes->pluck('mes')->toArray()) !!};

    var todosMeses = [...new Set([...notifEnviadasMeses, ...notifFallidasMeses, ...meses])].sort();
    var todosMesesNombres = todosMeses.map(function(m) {
        var partes = m.split('-');
        var nombres = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        return nombres[parseInt(partes[1]) - 1] + ' ' + partes[0];
    });

    var enviadasData = todosMeses.map(function(m) {
        var idx = notifEnviadasMeses.indexOf(m);
        return idx >= 0 ? notifEnviadas[idx] : 0;
    });

    var fallidasData = todosMeses.map(function(m) {
        var idx = notifFallidasMeses.indexOf(m);
        return idx >= 0 ? notifFallidas[idx] : 0;
    });

    new Chart(document.getElementById('chartNotificaciones'), {
        type: 'bar',
        data: {
            labels: todosMesesNombres,
            datasets: [{
                label: 'Enviadas',
                data: enviadasData,
                backgroundColor: '#059669',
                borderRadius: 4,
                borderSkipped: false
            }, {
                label: 'Fallidas',
                data: fallidasData,
                backgroundColor: '#e53e3e',
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 16, usePointStyle: true, pointStyle: 'circle', font: { size: 12, family: 'Segoe UI' } }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#333',
                    font: { weight: 'bold', size: 11 },
                    formatter: function(value) { return value > 0 ? value : ''; }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 11, family: 'Segoe UI' } },
                    grid: { color: '#f0f0f0' }
                },
                x: {
                    ticks: { font: { size: 11, family: 'Segoe UI' } },
                    grid: { display: false }
                }
            }
        }
    });

    new Chart(document.getElementById('chartBarras'), {
        type: 'line',
        data: {
            labels: mesesNombres,
            datasets: [{
                label: 'Registros',
                data: totalesMes,
                borderColor: '#1a3c6e',
                backgroundColor: 'rgba(26, 60, 110, 0.08)',
                borderWidth: 2.5,
                pointBackgroundColor: totalesMes.map(function(v, i) {
                    return i === totalesMes.length - 1 ? '#e8a820' : '#1a3c6e';
                }),
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#1a3c6e',
                    font: { weight: 'bold', size: 11 },
                    formatter: function(value) { return value > 0 ? value : ''; }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 11, family: 'Segoe UI' } },
                    grid: { color: '#f0f0f0' }
                },
                x: {
                    ticks: { font: { size: 11, family: 'Segoe UI' } },
                    grid: { display: false }
                }
            }
        }
    });

    new Chart(document.getElementById('chartValidaciones'), {
        type: 'doughnut',
        data: {
            labels: ['Validados ITM', 'No pertenece', 'Pendientes'],
            datasets: [{
                data: [{{ $validadosItm }}, {{ $noPertenece }}, {{ $pendientesVal }}],
                backgroundColor: ['#059669', '#e53e3e', '#B4B2A9'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 16, usePointStyle: true, pointStyle: 'circle', font: { size: 12, family: 'Segoe UI' } }
                },
                datalabels: {
                    color: '#fff',
                    font: { weight: 'bold', size: 13 },
                    formatter: function(value) { return value > 0 ? value : ''; }
                }
            }
        }
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/paises')
            .then(function(r) { return r.json(); })
            .then(function(paises) {
                var sel = document.getElementById('filtro-pais');
                paises.forEach(function(p) {
                    var opt = document.createElement('option');
                    opt.value = p.nombre;
                    opt.textContent = p.nombre;
                    opt.setAttribute('data-id', p.id);
                    if (p.nombre === '{{ request("pais") }}') opt.selected = true;
                    sel.appendChild(opt);
                });
                var paisActual = '{{ request("pais") }}';
                if (paisActual) filtrarPais(paisActual);
            });
    });

    function filtrarPais(paisNombre) {
        var sel = document.getElementById('filtro-pais');
        var selDep = document.getElementById('filtro-departamento');
        var selMun = document.getElementById('filtro-municipio');
        selDep.innerHTML = '<option value="">Todos</option>';
        selMun.innerHTML = '<option value="">Todos</option>';
        if (paisNombre === 'Colombia') {
            var opt = sel.options[sel.selectedIndex];
            var paisId = opt.getAttribute('data-id');
            fetch('/api/departamentos/' + paisId)
                .then(function(r) { return r.json(); })
                .then(function(deps) {
                    deps.forEach(function(d) {
                        var o = document.createElement('option');
                        o.value = d.nombre;
                        o.textContent = d.nombre;
                        o.setAttribute('data-id', d.id);
                        if (d.nombre === '{{ request("departamento") }}') o.selected = true;
                        selDep.appendChild(o);
                    });
                    var depActual = '{{ request("departamento") }}';
                    if (depActual) filtrarDepartamento(depActual);
                });
        }
    }

    function filtrarDepartamento(depNombre) {
        var selDep = document.getElementById('filtro-departamento');
        var selMun = document.getElementById('filtro-municipio');
        selMun.innerHTML = '<option value="">Todos</option>';
        if (depNombre) {
            var opt = selDep.options[selDep.selectedIndex];
            var depId = opt.getAttribute('data-id');
            fetch('/api/municipios/' + depId)
                .then(function(r) { return r.json(); })
                .then(function(muns) {
                    muns.forEach(function(m) {
                        var o = document.createElement('option');
                        o.value = m.nombre;
                        o.textContent = m.nombre;
                        if (m.nombre === '{{ request("municipio") }}') o.selected = true;
                        selMun.appendChild(o);
                    });
                });
        }
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