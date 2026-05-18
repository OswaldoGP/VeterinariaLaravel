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
