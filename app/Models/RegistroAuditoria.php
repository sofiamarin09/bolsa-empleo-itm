<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroAuditoria extends Model
{
    protected $table = 'registro_auditoria';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'tipo_evento',
        'descripcion',
        'ip_address',
        'usuario_id',
        'administrador_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioAspirante::class, 'usuario_id');
    }

    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'administrador_id');
    }
}