<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'usuario_id',
        'tipo_notificacion',
        'asunto',
        'estado_envio',
        'intentos',
        'fecha_envio',
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioAspirante::class, 'usuario_id');
    }
}