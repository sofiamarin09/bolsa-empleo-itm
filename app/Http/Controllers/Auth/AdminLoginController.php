<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use App\Models\RegistroAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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

        if (!$admin || !Hash::check($request->password, $admin->password_hash)) {
            return back()->withErrors(['error' => 'Credenciales incorrectas. Verifique su correo y contraseña.']);
        }

        Session::put('admin_id', $admin->id);
        Session::put('admin_nombre', $admin->nombre);

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

        Session::forget(['admin_id', 'admin_nombre']);

        return redirect()->route('admin.login');
    }
}