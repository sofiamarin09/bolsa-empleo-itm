<?php
 
namespace App\Services;
 
use Illuminate\Support\Facades\DB;

use App\Models\ValidacionAcademica;

use App\Models\RegistroAuditoria;
 
class ValidacionAcademicaService

{

    public function validar(int $usuarioId, string $numeroDocumento, string $nombreCompleto, string $ip = null): array

    {

        $resultado = $this->consultarSIA($numeroDocumento);
 
        ValidacionAcademica::create([

            'usuario_id' => $usuarioId,

            'resultado' => $resultado['estado'],

            'fuente' => 'SIA-ITM (simulado)',

            'detalle' => $resultado['detalle'],

        ]);
 
        RegistroAuditoria::create([

            'tipo_evento' => 'validacion_academica',

            'descripcion' => "Validación académica realizada. Documento: {$numeroDocumento}. Resultado: {$resultado['estado']}. {$resultado['detalle']}",

            'ip_address' => $ip,

            'usuario_id' => $usuarioId,

        ]);
 
        return $resultado;

    }
 
    private function consultarSIA(string $numeroDocumento): array

    {

        $registros = DB::table('sia_simulado')

            ->where('numero_documento', $numeroDocumento)

            ->get();
 
        if ($registros->isEmpty()) {

            return [

                'estado' => 'externo',

                'detalle' => 'El documento no fue encontrado en el sistema académico del ITM.',

                'valido' => true,

            ];

        }
 
        $estados = $registros->pluck('estado')->unique()->toArray();
 
        if (in_array('estudiante_activo', $estados) && in_array('egresado', $estados)) {

            return [

                'estado' => 'egresado_activo',

                'detalle' => 'Documento encontrado. El aspirante es egresado y estudiante activo.',

                'valido' => true,

            ];

        }
 
        if (in_array('estudiante_activo', $estados)) {

            return [

                'estado' => 'estudiante_activo',

                'detalle' => 'Documento encontrado. Estado: estudiante activo.',

                'valido' => true,

            ];

        }
 
        if (in_array('egresado', $estados)) {

            return [

                'estado' => 'egresado',

                'detalle' => 'Documento encontrado. Estado: egresado.',

                'valido' => true,

            ];

        }
 
        return [

            'estado' => $registros->first()->estado,

            'detalle' => 'Documento encontrado. Estado: ' . $registros->first()->estado,

            'valido' => true,

        ];

    }

}