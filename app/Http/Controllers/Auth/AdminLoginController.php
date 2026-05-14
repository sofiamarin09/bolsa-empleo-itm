<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use App\Models\RegistroAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminLoginController extends Controller
{
    public function showLogin()
    {
        if (Session::has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string',
        ], [
            'correo.required' => 'Ingrese su correo electrónico.',
            'correo.email' => 'Ingrese un correo válido.',
            'password.required' => 'Ingrese su contraseña.',
        ]);

        $admin = Administrador::where('correo', strtolower($request->correo))->first();

        if ($admin && !$admin->activo) {
            return back()->withErrors(['error' => 'Su cuenta se encuentra inactiva. Contacte a un SuperAdmin para reactivarla.']);
        }

        if (!$admin || !Hash::check($request->password, $admin->password_hash)) {
            return back()->withErrors(['error' => 'Credenciales incorrectas. Verifique su correo y contraseña.']);
        }

        Session::put('admin_id', $admin->id);
        Session::put('admin_nombre', $admin->nombre);
        Session::put('admin_rol', $admin->rol);

        RegistroAuditoria::create([
            'tipo_evento' => 'login_admin',
            'descripcion' => 'Inicio de sesión del administrador: ' . $admin->nombre,
            'ip_address' => $request->ip(),
            'administrador_id' => $admin->id,
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $adminId = Session::get('admin_id');

        if ($adminId) {
            RegistroAuditoria::create([
                'tipo_evento' => 'logout_admin',
                'descripcion' => 'Cierre de sesión del administrador',
                'ip_address' => $request->ip(),
                'administrador_id' => $adminId,
            ]);
        }

        Session::forget(['admin_id', 'admin_nombre', 'admin_rol']);

        return redirect()->route('admin.login');
    }

    public function showForgotPassword()
    {
        if (Session::has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
        ], [
            'correo.required' => 'Ingrese su correo electrónico.',
            'correo.email' => 'Ingrese un correo válido.',
        ]);

        $admin = Administrador::where('correo', strtolower($request->correo))->first();

        // Respuesta genérica para no revelar si el correo existe o no
        $mensaje = 'Si el correo está registrado, recibirá un enlace para restablecer su contraseña.';

        if ($admin && $admin->activo) {
            $token = Str::random(64);

            $admin->update([
                'password_reset_token'      => hash('sha256', $token),
                'password_reset_expires_at' => now()->addMinutes(60),
            ]);

            Mail::send('emails.admin-reset-password', [
                'admin' => $admin,
                'url'   => route('admin.reset-password.form', ['token' => $token, 'correo' => $admin->correo]),
            ], function ($message) use ($admin) {
                $message->to($admin->correo, $admin->nombre)
                        ->subject('ITM - Restablecer contraseña de administrador');
            });
        }

        return back()->with('success', $mensaje);
    }

    public function showResetPassword(Request $request, string $token)
    {
        return view('admin.reset-password', [
            'token'  => $token,
            'correo' => $request->query('correo', ''),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'correo'                => 'required|email',
            'token'                 => 'required|string',
            'password'              => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
        ], [
            'correo.required'                => 'El correo es obligatorio.',
            'password.required'              => 'La nueva contraseña es obligatoria.',
            'password.min'                   => 'La contraseña debe tener mínimo 8 caracteres.',
            'password_confirmation.required' => 'Debe confirmar la contraseña.',
            'password_confirmation.same'     => 'Las contraseñas no coinciden.',
        ]);

        $admin = Administrador::where('correo', strtolower($request->correo))
            ->whereNotNull('password_reset_token')
            ->first();

        $tokenValido = $admin
            && hash_equals($admin->password_reset_token, hash('sha256', $request->token))
            && $admin->password_reset_expires_at
            && now()->lessThanOrEqualTo($admin->password_reset_expires_at);

        if (!$tokenValido) {
            return back()->withErrors(['error' => 'El enlace es inválido o ha expirado. Solicite uno nuevo.']);
        }

        $admin->update([
            'password_hash'             => Hash::make($request->password),
            'password_reset_token'      => null,
            'password_reset_expires_at' => null,
        ]);

        RegistroAuditoria::create([
            'tipo_evento'     => 'reset_password_admin',
            'descripcion'     => 'Contraseña restablecida para: ' . $admin->nombre,
            'ip_address'      => $request->ip(),
            'administrador_id'=> $admin->id,
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'Contraseña restablecida correctamente. Ya puede iniciar sesión.');
    }
}