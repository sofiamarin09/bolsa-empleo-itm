<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Departamento extends Model
{
    protected $table = 'departamentos';
    protected $fillable = ['nombre', 'codigo_dane', 'pais_id'];
 
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }
 
    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'departamento_id');
    }
}