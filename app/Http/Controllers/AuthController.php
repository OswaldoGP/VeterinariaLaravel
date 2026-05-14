<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        return view("modules/auth/login");
    }

    public function registro(){
        return view("modules/auth/registro");
    }
    public function registrar(Request $request) {
        $item = new User();
        $item->name = $request->name;
        $item->email = $request->email;
        $item->password = Hash::make($request->password);
        $item->save();
        return to_route('login');
    }

    public function logear(Request $request) {
        $creadenciales = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($creadenciales)) {
            if (Auth::user()->rol === 'administrador') {
                return to_route('admin.home');
            }
            return to_route('home');
        } else {
            return to_route('login');
        }
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return to_route('login');
    }

    public function home() {
        if (!Auth::check() || Auth::user()->rol !== 'veterinario') {
            // Si es administrador, lo mandamos a su panel
            if (Auth::check() && Auth::user()->rol === 'administrador') {
                return to_route('admin.home');
            }
            return to_route('login');
        }
        return view('modules/dashboard/home');
    }

    public function adminHome() {
        if (!Auth::check() || Auth::user()->rol !== 'administrador') {
            // Si es veterinario, lo mandamos a su panel
            if (Auth::check() && Auth::user()->rol === 'veterinario') {
                return to_route('home');
            }
            return to_route('login');
        }
        return view('modules/dashboard/admin_home');
    }
}
