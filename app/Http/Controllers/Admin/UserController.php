<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(5);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        if ($request->rol === 'veterinario') {
            $user->veterinario()->create([
                'especialidad' => $request->especialidad,
                'telefono' => $request->telefono,
                'cedula_profesional' => $request->cedula_profesional,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        
        // Aquí se valida si el usuario tiene dependencias en otras tablas (ej. mascotas, citas, etc.)
        // Como 'veterinarios' tiene onDelete('cascade'), no impide la eliminación.
        $hasDependencies = false; 

        return view('admin.users.show', compact('user', 'hasDependencies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = $request->only(['name', 'email', 'rol']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($request->rol === 'veterinario') {
            $user->veterinario()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'especialidad' => $request->especialidad,
                    'telefono' => $request->telefono,
                    'cedula_profesional' => $request->cedula_profesional,
                ]
            );
        } else {
            if ($user->veterinario) {
                $user->veterinario()->delete();
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
