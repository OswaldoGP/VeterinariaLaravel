<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->rol === 'veterinario') {
            $user->load('veterinario');
        }
        return view('modules.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'foto_perfil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_perfil')) {
            // Delete old photo if exists
            if ($user->foto_perfil && Storage::exists('public/' . $user->foto_perfil)) {
                Storage::delete('public/' . $user->foto_perfil);
            }
            $path = $request->file('foto_perfil')->store('perfiles', 'public');
            $user->foto_perfil = $path;
            $user->save();
        }

        return back()->with('success', 'Perfil actualizado con éxito');
    }
}
