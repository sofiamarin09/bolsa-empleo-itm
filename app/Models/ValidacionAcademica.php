<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidacionAcademica extends Model
{
    protected $table = 'validaciones_academicas';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'resultado',
        'fuente',
        'detalle',
    ];

    protected $casts = [
        'fecha_validacion' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioAspirante::class, 'usuario_id');
    }
}