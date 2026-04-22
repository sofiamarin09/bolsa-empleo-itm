<?php
 
namespace App\Services;
 
use App\Models\Notificacion;
use App\Models\UsuarioAspirante;
use App\Models\RegistroAuditoria;
use Illuminate\Support\Facades\Mail;
 
class NotificacionService
{
    public function notificar(UsuarioAspirante $usuario, string $ip = null): void
    {
        $tipo = $this->getTipoNotificacion($usuario->estado_academico);
        $asunto = $this->getAsunto($usuario->estado_academico);
        $vista = $this->getVista($usuario->estado_academico);
 
        $notificacion = Notificacion::create([
            'usuario_id' => $usuario->id,
            'tipo_notificacion' => $tipo,
            'asunto' => $asunto,
            'estado_envio' => 'pendiente',
            'intentos' => 0,
        ]);
 
        try {
            Mail::send($vista, ['usuario' => $usuario], function ($message) use ($usuario, $asunto) {
                $message->to($usuario->correo, $usuario->primer_nombre . ' ' . $usuario->primer_apellido)
                        ->subject($asunto);
            });
 
            $notificacion->update([
                'estado_envio' => 'enviado',
                'intentos' => 1,
                'fecha_envio' => now(),
            ]);
 
        } catch (\Exception $e) {
            $notificacion->update([
                'estado_envio' => 'fallido',
                'intentos' => $notificacion->intentos + 1,
            ]);
        }
 
        RegistroAuditoria::create([
            'tipo_evento' => 'notificacion',
            'descripcion' => "Notificación enviada a {$usuario->correo}. Tipo: {$tipo}. Estado: {$notificacion->estado_envio}",
            'ip_address' => $ip,
            'usuario_id' => $usuario->id,
        ]);
    }
 
    private function getTipoNotificacion(string $estado): string
    {
        return match ($estado) {
            'estudiante_activo' => 'confirmacion_estudiante',
            'egresado' => 'confirmacion_egresado',
            'externo' => 'orientacion_externa',
            default => 'informativa',
        };
    }
 
    private function getAsunto(string $estado): string
    {
        return match ($estado) {
            'estudiante_activo' => 'ITM - Pre-registro exitoso - Estudiante activo',
            'egresado' => 'ITM - Pre-registro exitoso - Egresado',
            'externo' => 'ITM - Resultado de pre-registro',
            default => 'ITM - Notificación del sistema',
        };
    }
 
    private function getVista(string $estado): string
    {
        return match ($estado) {
            'estudiante_activo' => 'emails.estudiante-activo',
            'egresado' => 'emails.egresado',
            'externo' => 'emails.externo',
            default => 'emails.estudiante-activo',
        };
    }
}