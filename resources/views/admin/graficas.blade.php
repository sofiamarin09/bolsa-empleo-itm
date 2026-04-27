<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gráficas - ITM Bolsa de empleo</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
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
 
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
        .stat-card { background: white; border-radius: 10px; padding: 18px; border: 1px solid #e8e8e8; text-align: center; }
        .stat-card .label { font-size: 12px; color: #666; margin-bottom: 6px; }
        .stat-card .value { font-size: 26px; font-weight: 600; }
        .stat-card .value.total { color: #1a3c6e; }
        .stat-card .value.activo { color: #065f46; }
        .stat-card .value.egresado { color: #0C447C; }
        .stat-card .value.externo { color: #854F0B; }
 
        .charts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .chart-card { background: white; border-radius: 10px; padding: 24px; border: 1px solid #e8e8e8; }
        .chart-card h3 { color: #1a3c6e; font-size: 15px; font-weight: 600; margin-bottom: 16px; }
        .chart-container { position: relative; height: 280px; }
 
        .bar-item { margin-bottom: 14px; }
        .bar-label { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .bar-label span { font-size: 13px; color: #333; }
        .bar-label strong { font-size: 13px; color: #1a3c6e; }
        .bar-track { height: 10px; background: #f0f0f0; border-radius: 5px; overflow: hidden; }
        .bar-fill { height: 100%; border-radius: 5px; transition: width 0.5s ease; }
 
        .footer { background: #1a3c6e; color: white; text-align: center; padding: 20px; margin-top: 40px; }
        .footer p { font-size: 12px; opacity: 0.7; margin-bottom: 2px; }
 
        @media (max-width: 768px) {
            .header { padding: 14px 20px; flex-direction: column; gap: 10px; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .charts-grid { grid-template-columns: 1fr; }
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
<a href="{{ route('admin.administradores') }}" class="nav-link">Administradores</a>
<a href="{{ route('admin.graficas') }}" class="nav-link active">Gráficas</a>
</div>
 
        <div class="stats-grid">
<div class="stat-card">
<p class="label">Total registros</p>
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
<p class="label">Externos</p>
<p class="value externo">{{ $externos }}</p>
</div>
</div>
 
        <div class="charts-grid">
 
            <div class="chart-card">
<h3>Distribución por estado académico</h3>
<div class="chart-container">
<canvas id="chartTorta"></canvas>
</div>
</div>
 
            <div class="chart-card">
<h3>Registros por mes</h3>
<div class="chart-container">
<canvas id="chartBarras"></canvas>
</div>
</div>
 
            <div class="chart-card">
<h3>Notificaciones enviadas vs fallidas</h3>
<div class="chart-container">
<canvas id="chartNotificaciones"></canvas>
</div>
</div>
 
            <div class="chart-card">
<h3>Top departamentos</h3>
                @php $maxDep = $departamentos->max('total') ?: 1; @endphp
                @forelse($departamentos as $dep)
<div class="bar-item">
<div class="bar-label">
<span>{{ $dep->departamento }}</span>
<strong>{{ $dep->total }}</strong>
</div>
<div class="bar-track">
<div class="bar-fill" style="width: {{ ($dep->total / $maxDep) * 100 }}%; background: {{ $loop->index === 0 ? '#1a3c6e' : ($loop->index === 1 ? '#378ADD' : ($loop->index === 2 ? '#059669' : '#EF9F27')) }};"></div>
</div>
</div>
                @empty
<p style="color: #999; font-size: 13px; text-align: center; padding: 40px 0;">No hay datos disponibles.</p>
                @endforelse
</div>
 
        </div>
 
    </div>
 
    <footer class="footer">
<p>Instituto Tecnológico Metropolitano &mdash; Oficina de Egresados</p>
<p>Campus Fraternidad &mdash; &copy; {{ date('Y') }}</p>
</footer>
 
    <script>
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
            labels: ['Estudiantes activos', 'Egresados', 'Externos', 'Pendientes'],
            datasets: [{
                data: [{{ $estudiantesActivos }}, {{ $egresados }}, {{ $externos }}, {{ $pendientes }}],
                backgroundColor: ['#059669', '#378ADD', '#EF9F27', '#B4B2A9'],
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
                    labels: {
                        padding: 16,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { size: 12, family: 'Segoe UI' }
                    }
                }
            }
        }
    });
 
    new Chart(document.getElementById('chartBarras'), {
        type: 'bar',
        data: {
            labels: mesesNombres,
            datasets: [{
                label: 'Registros',
                data: totalesMes,
                backgroundColor: totalesMes.map(function(v, i) {
                    return i === totalesMes.length - 1 ? '#e8a820' : '#1a3c6e';
                }),
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 11, family: 'Segoe UI' }
                    },
                    grid: { color: '#f0f0f0' }
                },
                x: {
                    ticks: { font: { size: 11, family: 'Segoe UI' } },
                    grid: { display: false }
                }
            }
        }
    });
 
    var notifEnviadas = {!! json_encode($notifEnviadasPorMes->pluck('total')->toArray()) !!};
    var notifEnviadasMeses = {!! json_encode($notifEnviadasPorMes->pluck('mes')->toArray()) !!};
    var notifFallidas = {!! json_encode($notifFallidasPorMes->pluck('total')->toArray()) !!};
    var notifFallidasMeses = {!! json_encode($notifFallidasPorMes->pluck('mes')->toArray()) !!};
 
    var todosMeses = [...new Set([...notifEnviadasMeses, ...notifFallidasMeses])].sort();
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
        type: 'line',
        data: {
            labels: todosMesesNombres,
            datasets: [{
                label: 'Enviadas',
                data: enviadasData,
                borderColor: '#059669',
                backgroundColor: 'rgba(5, 150, 105, 0.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#059669',
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
                tension: 0.3
            }, {
                label: 'Fallidas',
                data: fallidasData,
                borderColor: '#e53e3e',
                backgroundColor: 'rgba(229, 62, 62, 0.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#e53e3e',
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
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 16,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { size: 12, family: 'Segoe UI' }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 11, family: 'Segoe UI' }
                    },
                    grid: { color: '#f0f0f0' }
                },
                x: {
                    ticks: { font: { size: 11, family: 'Segoe UI' } },
                    grid: { display: false }
                }
            }
        }
    });
</script>
 
</body>
</html>