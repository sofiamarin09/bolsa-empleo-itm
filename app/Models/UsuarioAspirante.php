<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioAspirante extends Model
{
    protected $table = 'usuarios_aspirantes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'tipo_documento',
        'numero_documento',
        'correo',
        'telefono_celular',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'sexo',
        'pais',
        'departamento',
        'municipio',
        'estado_academico',
        'acepta_terminos',
        'fecha_aceptacion_terminos',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'acepta_terminos' => 'boolean',
        'fecha_aceptacion_terminos' => 'datetime',
    ];

    public function validaciones()
    {
        return $this->hasMany(ValidacionAcademica::class, 'usuario_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'usuario_id');
    }

    public function auditorias()
    {
        return $this->hasMany(RegistroAuditoria::class, 'usuario_id');
    }
}