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
    Route::match(['get', 'post'], '/logout',[AuthController::class,'logout'])->name('logout');
    Route::resource('/admin/users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users');
});
