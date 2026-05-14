<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Administrador;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $admin = Administrador::find(Session::get('admin_id'));

        if (!$admin || !$admin->activo) {
            Session::forget(['admin_id', 'admin_nombre', 'admin_rol']);
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'Su cuenta ha sido desactivada. Contacte a un SuperAdmin.']);
        }

        return $next($request);
    }
}