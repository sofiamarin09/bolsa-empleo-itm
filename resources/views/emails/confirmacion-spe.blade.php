<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
    .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; border: 1px solid #e0e0e0; }
    .header { background: #1a3c6e; color: white; padding: 24px; text-align: center; }
    .header h1 { font-size: 20px; margin: 0; font-weight: 500; }
    .body { padding: 30px; }
    .body p { color: #555; line-height: 1.7; font-size: 14px; margin-bottom: 12px; }
    .info-box { background: #E6F1FB; padding: 16px; border-radius: 8px; color: #0C447C; font-size: 13px; line-height: 1.6; margin: 20px 0; }
    .btn { display: inline-block; background: #1a3c6e; color: white; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600; margin: 16px 0; }
    .footer { background: #f5f5f5; padding: 16px; text-align: center; font-size: 12px; color: #888; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>ITM - Bolsa de empleo</h1>
    </div>
    <div class="body">
        <p>Reciba un cordial saludo, {{ $usuario->primer_nombre }} {{ $usuario->primer_apellido }},</p>
        <p>El Programa de Egresados del Instituto Tecnológico Metropolitano (ITM) le informa que su información ha sido diligenciada correctamente en el <strong>Servicio Público de Empleo (SPE)</strong>.</p>
        <div class="info-box">
            En los próximos días recibirá en este mismo correo electrónico un mensaje de bienvenida de parte de <strong>sise@serviciodeempleo.gov.co</strong>, en el cual se le indicarán las credenciales (usuario y contraseña) de acceso al sistema.
        </div>
        <p>Para una correcta utilización del servicio, deberá ingresar al sistema a través del siguiente enlace y completar la información restante de su hoja de vida:</p>
        <a href="https://personas.serviciodeempleo.gov.co" class="btn">Ingresar al SPE</a>
        <p style="font-size: 13px; color: #888;">Si el botón no funciona, copie y pegue el siguiente enlace en su navegador:<br>https://personas.serviciodeempleo.gov.co</p>
        <p>Cordialmente,<br><strong>Programa de Egresados — ITM</strong></p>
    </div>
    <div class="footer">
        <p>Instituto Tecnológico Metropolitano &mdash; Programa de Egresados</p>
        <p>Campus Fraternidad</p>
        <p>Este es un correo automático, por favor no responda a este mensaje.</p>
    </div>
</div>
</body>
</html>