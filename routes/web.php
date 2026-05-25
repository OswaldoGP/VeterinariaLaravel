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
        $mascota->load('dueno');
        $consultas = $mascota->consultas()->with('veterinario.user')->orderBy('fecha_consulta', 'desc')->paginate(3);
        return view('modules.dashboard.consultas', compact('mascota', 'consultas'));
    })->name('expedientes.consultas');

    Route::get('/expedientes/{mascota}/consultas/create', function (\App\Models\Mascota $mascota) {
        $veterinarios = \App\Models\Veterinario::with('user')->get();
        return view('modules.dashboard.consulta_create', compact('mascota', 'veterinarios'));
    })->name('expedientes.consultas.create');

    Route::post('/expedientes/{mascota}/consultas', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota) {
        $request->validate([
            'veterinario_id' => 'required|exists:veterinarios,id',
            'fecha_consulta' => 'required|date',
            'peso' => 'nullable|numeric',
            'talla' => 'nullable|numeric',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'antecedentes' => 'nullable|string',
        ]);

        $mascota->consultas()->create($request->all());

        return redirect()->route('expedientes.consultas', $mascota->id)->with('success', 'Consulta registrada con éxito');
    })->name('expedientes.consultas.store');

    Route::get('/expedientes/{mascota}/consultas/{consulta}', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }
        $consulta->load('veterinario.user');
        $mascota->load('dueno');
        return view('modules.dashboard.consulta_show', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.show');

    Route::get('/expedientes/{mascota}/consultas/{consulta}/edit', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $veterinarios = \App\Models\Veterinario::with('user')->get();
        return view('modules.dashboard.consulta_edit', compact('mascota', 'consulta', 'veterinarios'));
    })->name('expedientes.consultas.edit');

    Route::put('/expedientes/{mascota}/consultas/{consulta}', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        
        $request->validate([
            'veterinario_id' => 'required|exists:veterinarios,id',
            'fecha_consulta' => 'required|date',
            'peso' => 'nullable|numeric',
            'talla' => 'nullable|numeric',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'antecedentes' => 'nullable|string',
        ]);

        $consulta->update($request->all());

        return redirect()->route('expedientes.consultas', $mascota->id)->with('success', 'Consulta actualizada con éxito');
    })->name('expedientes.consultas.update');

    Route::get('/expedientes/{mascota}/consultas/{consulta}/delete', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $consulta->load('veterinario.user');
        return view('modules.dashboard.consulta_delete', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.delete');

    Route::delete('/expedientes/{mascota}/consultas/{consulta}', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $consulta->delete();
        return redirect()->route('expedientes.consultas', $mascota->id)->with('success', 'Consulta eliminada con éxito');
    })->name('expedientes.consultas.destroy');

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

    Route::get('/expedientes/alergias/{alergia}/show', function (\App\Models\Alergia $alergia) {
        $mascota = $alergia->mascota;
        return view('modules.dashboard.mascota.alergias_show', compact('mascota', 'alergia'));
    })->name('expedientes.mascota.alergias.show');

    Route::get('/expedientes/alergias/{alergia}/edit', function (\App\Models\Alergia $alergia) {
        $mascota = $alergia->mascota;
        return view('modules.dashboard.mascota.alergias_edit', compact('mascota', 'alergia'));
    })->name('expedientes.mascota.alergias.edit');

    Route::put('/expedientes/alergias/{alergia}', function (\Illuminate\Http\Request $request, \App\Models\Alergia $alergia) {
        $request->validate(['nombre' => 'required|string', 'descripcion' => 'nullable|string']);
        $alergia->update($request->only('nombre', 'descripcion'));
        return redirect()->route('expedientes.mascota.alergias', $alergia->mascota_id)->with('success', 'Alergia actualizada con éxito');
    })->name('expedientes.mascota.alergias.update');

    Route::get('/expedientes/alergias/{alergia}/delete', function (\App\Models\Alergia $alergia) {
        $mascota = $alergia->mascota;
        return view('modules.dashboard.mascota.alergias_delete', compact('mascota', 'alergia'));
    })->name('expedientes.mascota.alergias.delete');

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

    Route::get('/expedientes/lesiones/{lesion}/show', function (\App\Models\Lesion $lesion) {
        $mascota = $lesion->mascota;
        return view('modules.dashboard.mascota.lesiones_show', compact('mascota', 'lesion'));
    })->name('expedientes.mascota.lesiones.show');

    Route::get('/expedientes/lesiones/{lesion}/edit', function (\App\Models\Lesion $lesion) {
        $mascota = $lesion->mascota;
        return view('modules.dashboard.mascota.lesiones_edit', compact('mascota', 'lesion'));
    })->name('expedientes.mascota.lesiones.edit');

    Route::put('/expedientes/lesiones/{lesion}', function (\Illuminate\Http\Request $request, \App\Models\Lesion $lesion) {
        $request->validate(['tipo' => 'required|string', 'descripcion' => 'nullable|string']);
        $lesion->update($request->only('tipo', 'descripcion'));
        return redirect()->route('expedientes.mascota.lesiones', $lesion->mascota_id)->with('success', 'Lesión actualizada con éxito');
    })->name('expedientes.mascota.lesiones.update');

    Route::get('/expedientes/lesiones/{lesion}/delete', function (\App\Models\Lesion $lesion) {
        $mascota = $lesion->mascota;
        return view('modules.dashboard.mascota.lesiones_delete', compact('mascota', 'lesion'));
    })->name('expedientes.mascota.lesiones.delete');

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

    Route::get('/expedientes/patologias/{patologia}/show', function (\App\Models\Patologia $patologia) {
        $mascota = $patologia->mascota;
        return view('modules.dashboard.mascota.patologias_show', compact('mascota', 'patologia'));
    })->name('expedientes.mascota.patologias.show');

    Route::get('/expedientes/patologias/{patologia}/edit', function (\App\Models\Patologia $patologia) {
        $mascota = $patologia->mascota;
        return view('modules.dashboard.mascota.patologias_edit', compact('mascota', 'patologia'));
    })->name('expedientes.mascota.patologias.edit');

    Route::put('/expedientes/patologias/{patologia}', function (\Illuminate\Http\Request $request, \App\Models\Patologia $patologia) {
        $request->validate(['nombre' => 'required|string', 'descripcion' => 'nullable|string']);
        $patologia->update($request->only('nombre', 'descripcion'));
        return redirect()->route('expedientes.mascota.patologias', $patologia->mascota_id)->with('success', 'Patología actualizada con éxito');
    })->name('expedientes.mascota.patologias.update');

    Route::get('/expedientes/patologias/{patologia}/delete', function (\App\Models\Patologia $patologia) {
        $mascota = $patologia->mascota;
        return view('modules.dashboard.mascota.patologias_delete', compact('mascota', 'patologia'));
    })->name('expedientes.mascota.patologias.delete');

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

    Route::get('/expedientes/alimentacion/{alimentacion}/show', function (\App\Models\Alimentacion $alimentacion) {
        $mascota = $alimentacion->mascota;
        return view('modules.dashboard.mascota.alimentacion_show', compact('mascota', 'alimentacion'));
    })->name('expedientes.mascota.alimentacion.show');

    Route::get('/expedientes/alimentacion/{alimentacion}/edit', function (\App\Models\Alimentacion $alimentacion) {
        $mascota = $alimentacion->mascota;
        return view('modules.dashboard.mascota.alimentacion_edit', compact('mascota', 'alimentacion'));
    })->name('expedientes.mascota.alimentacion.edit');

    Route::put('/expedientes/alimentacion/{alimentacion}', function (\Illuminate\Http\Request $request, \App\Models\Alimentacion $alimentacion) {
        $request->validate([
            'alimento' => 'required|string',
            'cantidad' => 'nullable|string',
            'frecuencia' => 'nullable|string',
            'observaciones' => 'nullable|string'
        ]);
        $alimentacion->update($request->only('alimento', 'cantidad', 'frecuencia', 'observaciones'));
        return redirect()->route('expedientes.mascota.alimentacion', $alimentacion->mascota_id)->with('success', 'Registro de alimentación actualizado');
    })->name('expedientes.mascota.alimentacion.update');

    Route::get('/expedientes/alimentacion/{alimentacion}/delete', function (\App\Models\Alimentacion $alimentacion) {
        $mascota = $alimentacion->mascota;
        return view('modules.dashboard.mascota.alimentacion_delete', compact('mascota', 'alimentacion'));
    })->name('expedientes.mascota.alimentacion.delete');

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
