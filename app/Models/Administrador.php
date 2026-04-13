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
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function auditorias()
    {
        return $this->hasMany(RegistroAuditoria::class, 'administrador_id');
    }
}