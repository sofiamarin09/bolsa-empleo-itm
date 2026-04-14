<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioAspirante;
use App\Models\PreguntaSeguridad;
use App\Models\RegistroAuditoria;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PreRegistroController extends Controller
{
    public function create()
    {
        $preguntas = PreguntaSeguridad::where('activa', true)->get();
        return view('pre-registro', compact('preguntas'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'correo' => strtolower($request->correo),
            'confirmar_correo' => strtolower($request->confirmar_correo),
        ]);

        $request->validate([
            'tipo_documento' => 'required|in:cedula_ciudadania,tarjeta_identidad,documento_nacional',
            'numero_documento' => 'required|regex:/^[0-9]+$/|min:6|max:15|unique:usuarios_aspirantes,numero_documento',
            'confirmar_documento' => 'required|same:numero_documento',
            'correo' => 'required|email|max:150|unique:usuarios_aspirantes,correo',
            'confirmar_correo' => 'required|same:correo',
            'primer_nombre' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+$/'],
            'segundo_nombre' => ['nullable', 'string', 'min:2', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+$/'],
            'primer_apellido' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+$/'],
            'segundo_apellido' => ['nullable', 'string', 'min:2', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+$/'],
            'fecha_nacimiento' => 'required|date|before:-14 years|after:-100 years',
            'sexo' => 'required|in:masculino,femenino',
            'telefono_celular' => 'required|regex:/^3[0-9]{9}$/',
            'pais' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+$/'],
            'departamento' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+$/'],
            'municipio' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+$/'],
            'pregunta_seguridad_id' => 'required|exists:preguntas_seguridad,id',
            'respuesta_seguridad' => 'required|string|min:3|max:255',
            'acepta_terminos' => 'accepted',
        ], [
            'numero_documento.unique' => 'Este número de documento ya está registrado.',
            'numero_documento.regex' => 'El número de documento solo debe contener números.',
            'numero_documento.min' => 'El número de documento debe tener mínimo 6 dígitos.',
            'numero_documento.max' => 'El número de documento debe tener máximo 15 dígitos.',
            'confirmar_documento.same' => 'Los números de documento no coinciden.',
            'correo.unique' => 'Este correo electrónico ya está registrado.',
            'confirmar_correo.same' => 'Los correos electrónicos no coinciden.',
            'acepta_terminos.accepted' => 'Debe aceptar el tratamiento de datos personales.',
            'fecha_nacimiento.before' => 'Debe tener al menos 14 años para registrarse.',
            'fecha_nacimiento.after' => 'La fecha de nacimiento no es válida.',
            'tipo_documento.in' => 'Seleccione un tipo de documento válido.',
            'sexo.in' => 'Seleccione un sexo válido.',
            'telefono_celular.regex' => 'El teléfono celular debe tener 10 dígitos y comenzar con 3.',
            'primer_nombre.regex' => 'El primer nombre solo debe contener letras.',
            'primer_nombre.min' => 'El primer nombre debe tener mínimo 2 caracteres.',
            'segundo_nombre.regex' => 'El segundo nombre solo debe contener letras.',
            'segundo_nombre.min' => 'El segundo nombre debe tener mínimo 2 caracteres.',
            'primer_apellido.regex' => 'El primer apellido solo debe contener letras.',
            'primer_apellido.min' => 'El primer apellido debe tener mínimo 2 caracteres.',
            'segundo_apellido.regex' => 'El segundo apellido solo debe contener letras.',
            'segundo_apellido.min' => 'El segundo apellido debe tener mínimo 2 caracteres.',
            'pais.regex' => 'El país solo debe contener letras.',
            'departamento.regex' => 'El departamento solo debe contener letras.',
            'municipio.regex' => 'El municipio solo debe contener letras.',
            'respuesta_seguridad.min' => 'La respuesta de seguridad debe tener mínimo 3 caracteres.',
        ]);

        try {
            DB::beginTransaction();

            $usuario = UsuarioAspirante::create([
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'correo' => $request->correo,
                'telefono_celular' => $request->telefono_celular,
                'primer_nombre' => $request->primer_nombre,
                'segundo_nombre' => $request->segundo_nombre,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'sexo' => $request->sexo,
                'pais' => $request->pais,
                'departamento' => $request->departamento,
                'municipio' => $request->municipio,
                'pregunta_seguridad_id' => $request->pregunta_seguridad_id,
                'respuesta_seguridad_hash' => Hash::make($request->respuesta_seguridad),
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

            DB::commit();

            return redirect()->route('pre-registro.exito')->with('usuario_id', $usuario->id);

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