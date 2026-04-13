<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro exitoso - ITM Bolsa de empleo</title>
<style>

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; }
 
        .header { background: #1a3c6e; color: white; padding: 18px 40px; display: flex; justify-content: space-between; align-items: center; }

        .header h1 { font-size: 20px; font-weight: 500; }
 
        .container { max-width: 600px; margin: 80px auto; padding: 0 20px; text-align: center; }
 
        .success-card {

            background: white;

            border-radius: 10px;

            padding: 50px 40px;

            box-shadow: 0 2px 8px rgba(0,0,0,0.06);

            border: 1px solid #e8e8e8;

        }

        .success-icon {

            width: 70px;

            height: 70px;

            background: #d1fae5;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            margin: 0 auto 24px;

        }

        .success-card h2 { color: #1a3c6e; margin-bottom: 14px; font-size: 22px; font-weight: 600; }

        .success-card p { color: #555; line-height: 1.7; margin-bottom: 12px; font-size: 14px; }

        .success-card p.note { color: #854F0B; background: #FAEEDA; padding: 12px 16px; border-radius: 8px; font-size: 13px; line-height: 1.6; margin-top: 20px; }
 
        .btn-home {

            background: #1a3c6e;

            color: white;

            padding: 12px 30px;

            border: none;

            border-radius: 6px;

            font-size: 14px;

            font-weight: 600;

            text-decoration: none;

            display: inline-block;

            margin-top: 24px;

            transition: background 0.2s;

        }

        .btn-home:hover { background: #15325a; }
 
        .footer { background: #1a3c6e; color: white; text-align: center; padding: 24px 20px; margin-top: 80px; }

        .footer p { font-size: 13px; opacity: 0.8; margin-bottom: 4px; }

        .footer p:last-child { opacity: 0.6; font-size: 12px; margin-bottom: 0; }
 
        @media (max-width: 600px) {

            .header { padding: 14px 20px; }

            .success-card { padding: 30px 20px; }

        }
</style>
</head>
<body>
 
    <header class="header">
<h1>ITM - Bolsa de empleo</h1>
</header>
 
    <div class="container">
<div class="success-card">
<div class="success-icon">
<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
<path d="M20 6L9 17l-5-5"/>
</svg>
</div>
<h2>Pre-registro enviado exitosamente</h2>
<p>Su información ha sido recibida correctamente. El sistema validará su estado académico con el Sistema de Información Académica del ITM (SIA) y recibirá una notificación por correo electrónico con el resultado.</p>
<p class="note">Recuerde que este es el primer paso del proceso. Una vez validada su información, la Oficina de Egresados gestionará sus datos ante el Servicio Público de Empleo (SPE) donde deberá continuar con el proceso.</p>
<a href="/" class="btn-home">Volver al inicio</a>
</div>
</div>
 
    <footer class="footer">
<p>Instituto Tecnológico Metropolitano &mdash; Oficina de Egresados</p>
<p>Campus Fraternidad &mdash; &copy; {{ date('Y') }}</p>
</footer>
 
</body>
</html>
 