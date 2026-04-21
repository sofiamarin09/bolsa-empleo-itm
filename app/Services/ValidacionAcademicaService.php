<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\ValidacionAcademica;
use App\Models\RegistroAuditoria;

class ValidacionAcademicaService
{
    public function validar(int $usuarioId, string $numeroDocumento, string $nombreCompleto, string $ip = null): array
    {
        $resultado = $this->consultarSIA($numeroDocumento, $nombreCompleto);

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

    private function consultarSIA(string $numeroDocumento, string $nombreCompleto): array
    {
        $registro = DB::table('sia_simulado')
            ->where('numero_documento', $numeroDocumento)
            ->first();

        if (!$registro) {
            return [
                'estado' => 'externo',
                'detalle' => 'El documento no fue encontrado en el sistema académico del ITM.',
                'valido' => true,
            ];
        }

        $nombreSIA = $this->normalizarTexto($registro->nombre_completo);
        $nombreIngresado = $this->normalizarTexto($nombreCompleto);

        if ($nombreSIA !== $nombreIngresado) {
            return [
                'estado' => 'error_nombre',
                'detalle' => 'El nombre ingresado no coincide con el registrado en el sistema académico del ITM.',
                'valido' => false,
            ];
        }

        return [
            'estado' => $registro->estado,
            'detalle' => 'Documento encontrado. Estado: ' . $registro->estado,
            'valido' => true,
        ];
    }

    private function normalizarTexto(string $texto): string
    {
        $texto = mb_strtolower(trim($texto));
        $texto = preg_replace('/\s+/', ' ', $texto);
        $originales = ['á','é','í','ó','ú','ü','ñ'];
        $reemplazos = ['a','e','i','o','u','u','n'];
        $texto = str_replace($originales, $reemplazos, $texto);
        return $texto;
    }
}