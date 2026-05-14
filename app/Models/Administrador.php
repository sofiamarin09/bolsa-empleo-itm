<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    protected $table = 'administradores';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'password_hash',
        'rol',
        'activo',
        'password_reset_token',
        'password_reset_expires_at',
    ];

    protected $hidden = [
        'password_hash',
        'password_reset_token',
    ];

    protected $casts = [
        'created_at'                 => 'datetime',
        'activo'                     => 'boolean',
        'password_reset_expires_at'  => 'datetime',
    ];

    public function auditorias()
    {
        return $this->hasMany(RegistroAuditoria::class, 'administrador_id');
    }
}