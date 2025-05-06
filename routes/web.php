<?php

use App\Http\Controllers\administracion\CitaController;
use App\Http\Controllers\administracion\ConsultaController;
use App\Http\Controllers\administracion\DocumentoController;
use App\Http\Controllers\administracion\PacienteController;
use App\Http\Controllers\administracion\VacunaController;
use App\Http\Controllers\catalogo\ProductoController;
use App\Http\Controllers\catalogo\TipoVacunaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});


Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::post('user/update_password', [UserController::class, 'updatePassword']);




    //expediente

    Route::post('paciente/vacuna', [VacunaController::class,'store'])->name('paciente.vacuna');
    Route::put('paciente/vacuna/update/{id}', [VacunaController::class,'update'])->name('paciente.vacuna.update');
    Route::delete('paciente/vacuna/destroy/{id}', [VacunaController::class,'destroy'])->name('paciente.vacuna.destroy');


    Route::post('paciente/cita',  [CitaController::class,'store'])->name('paciente.cita');
    Route::put('paciente/cita/update/{id}',  [CitaController::class,'update'])->name('paciente.cita.update');
    Route::delete('paciente/cita/destroy/{id}',  [CitaController::class,'destroy'])->name('paciente.cita.destroy');

    Route::get('cita/calendario', [CitaController::class, 'calendario']);
    Route::get('cita/calendario/get_eventos/{mes}/{anio}', [CitaController::class, 'get_eventos']);
    Route::get('cita/calendario/get_lista_eventos/{mes}/{anio}', [CitaController::class, 'get_lista_eventos']);
    Route::post('cita/store_cita', [CitaController::class, 'calendario_store_cita']);



    Route::get('paciente/carga_documento', [PacienteController::class,'carga_documento']);
    Route::post('paciente/carga_documento', [PacienteController::class,'procesar_documento']);
    Route::post('paciente/documento', [DocumentoController::class,'store'])->name('paciente.documento');
    Route::delete('paciente/documento/destroy/{id}', [DocumentoController::class,'destroy'])->name('paciente.documento.destroy');
    Route::get('paciente/get_distritos/{id}', [PacienteController::class,'get_distritos']);
    Route::put('paciente/update_antecedentes/{id}', [PacienteController::class,'update_antecedentes']);
    Route::resource('paciente', PacienteController::class);

    Route::post('consulta/store_receta', [ConsultaController::class,'store_receta']);
    Route::put('/consulta/update_receta/{id}', [ConsultaController::class, 'update_receta'])->name('consulta.update_receta');
    Route::delete('/consulta/delete_receta/{id}', [ConsultaController::class, 'delete_receta'])->name('consulta.delete_receta');



    Route::resource('consulta', ConsultaController::class);


    //catalogos
    Route::resource('producto', ProductoController::class);
    Route::resource('tipo_vacuna', TipoVacunaController::class);

});
