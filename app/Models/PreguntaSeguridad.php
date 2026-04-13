<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntaSeguridad extends Model
{
    protected $table = 'preguntas_seguridad';
    public $timestamps = false;

    protected $fillable = [
        'pregunta',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    public function usuarios()
    {
        return $this->hasMany(UsuarioAspirante::class, 'pregunta_seguridad_id');
    }
}