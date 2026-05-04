<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Municipio extends Model

{

    protected $table = 'municipios';

    protected $fillable = ['nombre', 'codigo_dane', 'departamento_id'];
 
    public function departamento()

    {

        return $this->belongsTo(Departamento::class, 'departamento_id');

    }

}
 