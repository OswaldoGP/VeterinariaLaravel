<?php

use App\Http\Controllers\AuthController;
use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware("guest")->group(function () {
    Route::get('/',[AuthController::class, 'index'])->name('login');
    Route::get('/registro',[AuthController::class, 'registro'])->name('registro');
    Route::post('/registrar',[AuthController::class,'registrar'])->name('registrar');
    Route::post('/logear',[AuthController::class,'logear'])->name('logear');
});

Route::middleware("auth")->group(function () {
    Route::get('/perfil', [\App\Http\Controllers\ProfileController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [\App\Http\Controllers\ProfileController::class, 'update'])->name('perfil.update');

    Route::get('/home',[AuthController::class,'home'])->name('home');
    
    Route::view('/expedientes', 'modules.dashboard.expedientes')->name('expedientes.index');
    Route::get('/expedientes/{mascota}/consultas', function (\App\Models\Mascota $mascota) {
        $mascota->load('dueno', 'consultas.veterinario.user');
        return view('modules.dashboard.consultas', compact('mascota'));
    })->name('expedientes.consultas');

    Route::get('/expedientes/{mascota}/consultas/{consulta}', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }
        $consulta->load('veterinario.user');
        $mascota->load('dueno');
        return view('modules.dashboard.consulta_show', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.show');

    Route::get('/expedientes/{mascota}/consultas/{consulta}/diagnostico', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        return view('modules.dashboard.diagnostico', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.diagnostico');

    Route::put('/expedientes/{mascota}/consultas/{consulta}/diagnostico', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $request->validate(['diagnostico' => 'nullable|string']);
        
        $esNuevo = empty($consulta->diagnostico);
        
        $consulta->update(['diagnostico' => $request->diagnostico]);
        
        $mensaje = $esNuevo ? 'se guardo la nueva informacion' : 'se actualizo con exito';
        
        return redirect()->route('expedientes.consultas.diagnostico', [$mascota->id, $consulta->id])->with('success', $mensaje);
    })->name('expedientes.consultas.diagnostico.update');

    Route::get('/expedientes/{mascota}/consultas/{consulta}/tratamiento', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        return view('modules.dashboard.tratamiento', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.tratamiento');

    Route::put('/expedientes/{mascota}/consultas/{consulta}/tratamiento', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $request->validate(['tratamiento' => 'nullable|string']);
        
        $esNuevo = empty($consulta->tratamiento);
        
        $consulta->update(['tratamiento' => $request->tratamiento]);
        
        $mensaje = $esNuevo ? 'se guardo la nueva informacion' : 'se actualizo con exito';
        
        return redirect()->route('expedientes.consultas.tratamiento', [$mascota->id, $consulta->id])->with('success', $mensaje);
    })->name('expedientes.consultas.tratamiento.update');

    // Módulos de Mascota (Alergias, Lesiones, Patologías, Alimentación)
    Route::get('/expedientes/{mascota}/alergias', function (\App\Models\Mascota $mascota) {
        $mascota->load('alergias');
        return view('modules.dashboard.mascota.alergias', compact('mascota'));
    })->name('expedientes.mascota.alergias');

    Route::post('/expedientes/{mascota}/alergias', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota) {
        $request->validate(['nombre' => 'required|string', 'descripcion' => 'nullable|string']);
        $mascota->alergias()->create($request->only('nombre', 'descripcion'));
        return redirect()->route('expedientes.mascota.alergias', $mascota->id)->with('success', 'Alergia registrada con éxito');
    })->name('expedientes.mascota.alergias.store');

    Route::delete('/expedientes/alergias/{alergia}', function (\App\Models\Alergia $alergia) {
        $mascota_id = $alergia->mascota_id;
        $alergia->delete();
        return redirect()->route('expedientes.mascota.alergias', $mascota_id)->with('success', 'Alergia eliminada');
    })->name('expedientes.mascota.alergias.destroy');

    Route::get('/expedientes/{mascota}/lesiones', function (\App\Models\Mascota $mascota) {
        $mascota->load('lesiones');
        return view('modules.dashboard.mascota.lesiones', compact('mascota'));
    })->name('expedientes.mascota.lesiones');

    Route::post('/expedientes/{mascota}/lesiones', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota) {
        $request->validate(['tipo' => 'required|string', 'descripcion' => 'nullable|string']);
        $mascota->lesiones()->create($request->only('tipo', 'descripcion'));
        return redirect()->route('expedientes.mascota.lesiones', $mascota->id)->with('success', 'Lesión registrada con éxito');
    })->name('expedientes.mascota.lesiones.store');

    Route::delete('/expedientes/lesiones/{lesion}', function (\App\Models\Lesion $lesion) {
        $mascota_id = $lesion->mascota_id;
        $lesion->delete();
        return redirect()->route('expedientes.mascota.lesiones', $mascota_id)->with('success', 'Lesión eliminada');
    })->name('expedientes.mascota.lesiones.destroy');

    Route::get('/expedientes/{mascota}/patologias', function (\App\Models\Mascota $mascota) {
        $mascota->load('patologias');
        return view('modules.dashboard.mascota.patologias', compact('mascota'));
    })->name('expedientes.mascota.patologias');

    Route::post('/expedientes/{mascota}/patologias', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota) {
        $request->validate(['nombre' => 'required|string', 'descripcion' => 'nullable|string']);
        $mascota->patologias()->create($request->only('nombre', 'descripcion'));
        return redirect()->route('expedientes.mascota.patologias', $mascota->id)->with('success', 'Patología registrada con éxito');
    })->name('expedientes.mascota.patologias.store');

    Route::delete('/expedientes/patologias/{patologia}', function (\App\Models\Patologia $patologia) {
        $mascota_id = $patologia->mascota_id;
        $patologia->delete();
        return redirect()->route('expedientes.mascota.patologias', $mascota_id)->with('success', 'Patología eliminada');
    })->name('expedientes.mascota.patologias.destroy');

    Route::get('/expedientes/{mascota}/alimentacion', function (\App\Models\Mascota $mascota) {
        $mascota->load('alimentaciones');
        return view('modules.dashboard.mascota.alimentacion', compact('mascota'));
    })->name('expedientes.mascota.alimentacion');

    Route::post('/expedientes/{mascota}/alimentacion', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota) {
        $request->validate([
            'alimento' => 'required|string',
            'cantidad' => 'nullable|string',
            'frecuencia' => 'nullable|string',
            'observaciones' => 'nullable|string'
        ]);
        $mascota->alimentaciones()->create($request->only('alimento', 'cantidad', 'frecuencia', 'observaciones'));
        return redirect()->route('expedientes.mascota.alimentacion', $mascota->id)->with('success', 'Registro de alimentación guardado');
    })->name('expedientes.mascota.alimentacion.store');

    Route::delete('/expedientes/alimentacion/{alimentacion}', function (\App\Models\Alimentacion $alimentacion) {
        $mascota_id = $alimentacion->mascota_id;
        $alimentacion->delete();
        return redirect()->route('expedientes.mascota.alimentacion', $mascota_id)->with('success', 'Registro de alimentación eliminado');
    })->name('expedientes.mascota.alimentacion.destroy');

    Route::get('/expedientes/search', function (Request $request) {
        $query = $request->input('q');
        if (!$query) {
            return response()->json([]);
        }
        
        // Usamos Scout para buscar
        $resultados = Mascota::search($query)->take(10)->get();
        $resultados->load('dueno'); // Cargar la relación para JS
        
        return response()->json($resultados);
    })->name('expedientes.search');
    Route::get('/admin/home', [AuthController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/acerca', function () {
        return view('modules.dashboard.admin_acerca');
    })->name('admin.acerca');
    Route::match(['get', 'post'], '/logout',[AuthController::class,'logout'])->name('logout');
    Route::resource('/admin/users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users');
});
