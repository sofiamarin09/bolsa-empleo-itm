<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioAspirante;
use App\Models\RegistroAuditoria;
use App\Services\ValidacionAcademicaService;
use Illuminate\Support\Facades\DB;
use App\Services\NotificacionService;

class PreRegistroController extends Controller
{
    public function create()
    {
        return view('pre-registro');
    }

    public function store(Request $request)
    {
        $request->merge([
            'correo' => strtolower($request->correo),
            'confirmar_correo' => strtolower($request->confirmar_correo),
        ]);

        $request->validate([
            'tipo_documento' => 'required|in:cedula_ciudadania,tarjeta_identidad,documento_nacional',
            'numero_documento' => 'required|string|min:6|max:15|regex:/^[0-9]+$/|unique:usuarios_aspirantes,numero_documento',
            'confirmar_documento' => 'required|same:numero_documento',
            'correo' => 'required|email|max:150|unique:usuarios_aspirantes,correo',
            'confirmar_correo' => 'required|same:correo',
            'primer_nombre' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+$/'],
            'segundo_nombre' => ['nullable', 'string', 'min:2', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+$/'],
            'primer_apellido' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+$/'],
            'segundo_apellido' => ['nullable', 'string', 'min:2', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+$/'],
            'fecha_nacimiento' => 'required|date|before_or_equal:' . now()->subYears(14)->format('Y-m-d') . '|after_or_equal:' . now()->subYears(100)->format('Y-m-d'),
            'sexo' => 'required|in:masculino,femenino,intersexual',
            'telefono' => 'required|string|min:7|max:15|regex:/^[+0-9]+$/',
            'pais' => 'required|string|min:2|max:100',
            'departamento' => 'nullable|string|min:2|max:100',
            'municipio' => 'nullable|string|min:2|max:100',
            'acepta_terminos' => 'accepted',
            'acepta_terminos_spe' => 'accepted',
        ], [
            'tipo_documento.required' => 'Seleccione un tipo de documento.',
            'tipo_documento.in' => 'El tipo de documento seleccionado no es válido.',
            'numero_documento.required' => 'El número de documento es obligatorio.',
            'numero_documento.min' => 'El número de documento debe tener mínimo 6 dígitos.',
            'numero_documento.max' => 'El número de documento debe tener máximo 15 dígitos.',
            'numero_documento.regex' => 'El número de documento solo debe contener números.',
            'numero_documento.unique' => 'Este número de documento ya se encuentra registrado.',
            'confirmar_documento.required' => 'Debe confirmar el número de documento.',
            'confirmar_documento.same' => 'Los números de documento no coinciden.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Ingrese un correo electrónico válido.',
            'correo.unique' => 'Este correo electrónico ya se encuentra registrado.',
            'confirmar_correo.required' => 'Debe confirmar el correo electrónico.',
            'confirmar_correo.same' => 'Los correos electrónicos no coinciden.',
            'primer_nombre.required' => 'El primer nombre es obligatorio.',
            'primer_nombre.min' => 'El primer nombre debe tener mínimo 2 caracteres.',
            'primer_nombre.regex' => 'El primer nombre solo debe contener letras.',
            'segundo_nombre.min' => 'El segundo nombre debe tener mínimo 2 caracteres.',
            'segundo_nombre.regex' => 'El segundo nombre solo debe contener letras.',
            'primer_apellido.required' => 'El primer apellido es obligatorio.',
            'primer_apellido.min' => 'El primer apellido debe tener mínimo 2 caracteres.',
            'primer_apellido.regex' => 'El primer apellido solo debe contener letras.',
            'segundo_apellido.min' => 'El segundo apellido debe tener mínimo 2 caracteres.',
            'segundo_apellido.regex' => 'El segundo apellido solo debe contener letras.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.before_or_equal' => 'Debe tener al menos 14 años para registrarse.',
            'fecha_nacimiento.after_or_equal' => 'La fecha de nacimiento no es válida.',
            'sexo.required' => 'Seleccione el sexo.',
            'sexo.in' => 'El sexo seleccionado no es válido.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.min' => 'El teléfono debe tener mínimo 7 dígitos.',
            'telefono.max' => 'El teléfono debe tener máximo 15 dígitos.',
            'telefono.regex' => 'El teléfono solo debe contener números y el carácter +.',
            'pais.required' => 'El país es obligatorio.',
            'pais.min' => 'El país debe tener mínimo 2 caracteres.',
            'departamento.min' => 'El departamento debe tener mínimo 2 caracteres.',
            'municipio.min' => 'El municipio debe tener mínimo 2 caracteres.',
            'acepta_terminos.accepted' => 'Debe aceptar el tratamiento de datos personales del ITM.',
            'acepta_terminos_spe.accepted' => 'Debe aceptar los términos y condiciones del SPE.',
        ]);

        if ($request->pais === 'Colombia') {
            if (!$request->filled('departamento')) {
                return back()->withInput()->withErrors(['departamento' => 'El departamento es obligatorio para Colombia.']);
            }
            if (!$request->filled('municipio')) {
                return back()->withInput()->withErrors(['municipio' => 'El municipio es obligatorio para Colombia.']);
            }
        } else {
            $request->merge([
                'departamento' => null,
                'municipio' => null,
            ]);
        }

        try {
            DB::beginTransaction();

            $usuario = UsuarioAspirante::create([
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'primer_nombre' => $request->primer_nombre,
                'segundo_nombre' => $request->segundo_nombre,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'sexo' => $request->sexo,
                'pais' => $request->pais,
                'departamento' => $request->departamento,
                'municipio' => $request->municipio,
                'estado_academico' => 'pendiente',
                'acepta_terminos' => true,
                'fecha_aceptacion_terminos' => now(),
            ]);

            RegistroAuditoria::create([
                'tipo_evento' => 'pre_registro',
                'descripcion' => 'Pre-registro realizado por ' . $request->primer_nombre . ' ' . $request->primer_apellido,
                'ip_address' => $request->ip(),
                'usuario_id' => $usuario->id,
            ]);

            $nombreCompleto = trim($request->primer_nombre . ' ' . ($request->segundo_nombre ?? '') . ' ' . $request->primer_apellido . ' ' . ($request->segundo_apellido ?? ''));
            $nombreCompleto = preg_replace('/\s+/', ' ', $nombreCompleto);

            $servicio = new ValidacionAcademicaService();
            $resultado = $servicio->validar($usuario->id, $request->numero_documento, $nombreCompleto, $request->ip());

            if (!$resultado['valido']) {
                DB::rollBack();
                return back()->withInput()->withErrors(['error' => $resultado['detalle']]);
            }

            $usuario->update(['estado_academico' => $resultado['estado']]);
            $notificacionService = new NotificacionService();
            $notificacionService->notificar($usuario, $request->ip());

            DB::commit();

            return redirect()->route('pre-registro.exito')->with([
                'usuario_id' => $usuario->id,
                'estado_academico' => $resultado['estado'],
                'documento' => $usuario->numero_documento,
                'correo' => $usuario->correo,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Ocurrió un error al procesar el registro. Intente nuevamente.']);
        }
    }

    public function exito()
    {
        return view('pre-registro-exito');
    }
}