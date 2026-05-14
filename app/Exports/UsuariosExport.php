<?php

namespace App\Exports;

use App\Models\UsuarioAspirante;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsuariosExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected ?string $estado;
    protected ?string $fechaDesde;
    protected ?string $fechaHasta;
    protected ?string $gestionSpe;

    public function __construct($estado = null, $fechaDesde = null, $fechaHasta = null, $gestionSpe = null)
    {
        $this->estado = $estado;
        $this->fechaDesde = $fechaDesde;
        $this->fechaHasta = $fechaHasta;
        $this->gestionSpe = $gestionSpe;
    }

    public function query()
    {
        $query = UsuarioAspirante::query();

        if ($this->estado) {
            $estados = explode(',', $this->estado);
            $query->whereIn('estado_academico', $estados);
        }

        if ($this->fechaDesde) {
            $query->whereDate('created_at', '>=', $this->fechaDesde);
        }

        if ($this->fechaHasta) {
            $query->whereDate('created_at', '<=', $this->fechaHasta);
        }

        if ($this->gestionSpe === 'gestionado') {
            $query->where('gestionado_spe', true);
        } elseif ($this->gestionSpe === 'pendiente') {
            $query->where('gestionado_spe', false);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tipo de documento',
            'Número de documento',
            'Primer nombre',
            'Segundo nombre',
            'Primer apellido',
            'Segundo apellido',
            'Correo electrónico',
            'Teléfono',
            'Fecha de nacimiento',
            'Sexo',
            'País',
            'Departamento',
            'Municipio',
            'Tipo de usuario ITM',
            'Fecha de registro',
        ];
    }

    public function map($usuario): array
    {
        return [
            $usuario->id,
            $this->formatoTipoDocumento($usuario->tipo_documento),
            $usuario->numero_documento,
            $usuario->primer_nombre,
            $usuario->segundo_nombre ?? '',
            $usuario->primer_apellido,
            $usuario->segundo_apellido ?? '',
            $usuario->correo,
            $usuario->telefono,
            $usuario->fecha_nacimiento->format('d/m/Y'),
            ucfirst($usuario->sexo),
            $usuario->pais,
            $usuario->departamento ?? '',
            $usuario->municipio ?? '',
            $this->formatoEstado($usuario->estado_academico),
            $usuario->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        $sheet->getStyle('C2:C' . $lastRow)->getNumberFormat()->setFormatCode('@');
        $sheet->getStyle('I2:I' . $lastRow)->getNumberFormat()->setFormatCode('@');

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1A3C6E'],
                ],
            ],
        ];
    }

    private function formatoTipoDocumento(string $tipo): string
    {
        return match ($tipo) {
            'cedula_ciudadania' => 'Cédula de ciudadanía',
            'tarjeta_identidad' => 'Tarjeta de identidad',
            'documento_nacional' => 'Documento nacional',
            default => $tipo,
        };
    }

    private function formatoEstado(string $estado): string
    {
        return match ($estado) {
            'estudiante_activo' => 'Estudiante activo',
            'egresado' => 'Egresado',
            'egresado_activo' => 'Egresado y estudiante activo',
            'externo' => 'No pertenece al ITM',
            'pendiente' => 'Pendiente',
            default => $estado,
        };
    }
}