<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
    .wrapper { max-width: 560px; margin: 30px auto; background: white; border-radius: 10px; overflow: hidden; border: 1px solid #e0e0e0; }
    .header { background: #1a3c6e; padding: 28px 32px; text-align: center; }
    .header h1 { color: white; font-size: 18px; font-weight: 600; margin: 0; }
    .body { padding: 32px; color: #333; }
    .body p { font-size: 14px; line-height: 1.7; margin-bottom: 16px; }
    .btn-wrapper { text-align: center; margin: 28px 0; }
    .btn { background: #1a3c6e; color: white; padding: 13px 32px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-block; }
    .note { font-size: 12px; color: #999; border-top: 1px solid #f0f0f0; padding-top: 16px; margin-top: 8px; }
    .footer { background: #f5f5f5; padding: 16px 32px; text-align: center; font-size: 12px; color: #999; }
</style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>ITM &mdash; Bolsa de Empleo</h1>
    </div>
    <div class="body">
        <p>Hola, <strong>{{ $admin->nombre }}</strong>.</p>
        <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta de administrador. Haz clic en el botón para crear una nueva contraseña:</p>
        <div class="btn-wrapper">
            <a href="{{ $url }}" class="btn">Restablecer contraseña</a>
        </div>
        <p class="note">
            Este enlace expira en <strong>60 minutos</strong>. Si no solicitaste este cambio, puedes ignorar este mensaje — tu contraseña actual seguirá siendo la misma.<br><br>
            Si el botón no funciona, copia y pega este enlace en tu navegador:<br>
            <span style="color:#1a3c6e; word-break:break-all;">{{ $url }}</span>
        </p>
    </div>
    <div class="footer">
        Instituto Tecnológico Metropolitano &mdash; Programa de Egresados
    </div>
</div>
</body>
</html>
