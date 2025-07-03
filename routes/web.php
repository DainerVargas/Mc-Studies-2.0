<?php

use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AttendantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\descargaController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/* LOGIN */
Route::get('/', [AuthenticationController::class, 'index'])->middleware('guest')->name('index');

Route::get('Login', [AuthenticationController::class, 'login'])->middleware('guest')->name('login');

Route::post('Login', [AuthenticationController::class, 'loginPost'])->name('loginPost');

/* LOGOUT */
Route::get('Cerrar Sesion', [AuthenticationController::class, 'logout'])->name('logout');

/* FORGOT */
Route::get('Recuperar-Contraseña', [ForgotController::class, 'forgot'])->middleware('guest')->name('forgot');

Route::post('Recuperar-Contraseña', [ForgotController::class, 'forgotPassword'])->middleware('guest')->name('forgotPassword');

/* APRENDINCES */
Route::get('Lista-Aprendiz', [ApprenticeController::class, 'lista'])->middleware('auth')->name('listaAprendiz');

/* INFORMACION DEL APRENDIZ */
Route::get('Informacion/{aprendiz}', [ApprenticeController::class, 'info'])->middleware('auth')->name('informacion');

/* PROFESORES */
Route::get('Lista-Profesores', [TeacherController::class, 'lista'])->middleware('auth')->name('listaProfesor');

Route::get('Informacion-Profesor/{teacher}', [TeacherController::class, 'infoteacher'])->middleware('auth')->name('infoProfesor');

/* REGISTRO */

Route::get('Registrate', [AuthenticationController::class, 'registrar'])->name('registro');

Route::post('Registrate', [AuthenticationController::class, 'store'])->name('store');

/* CREAR GRUPO */

Route::get('Crear-grupo', [GroupController::class, 'index'])->middleware('auth')->name('grupo');

/* ACTUALIZAR INFORMACIÓN */

Route::get('Actualizar-Informacion/{aprendiz}', [AttendantController::class, 'viewUpdate'])->middleware('auth')->name('viewUpdate');

Route::post('Actualizar-Informacion/{aprendiz}', [AttendantController::class, 'update'])->middleware('auth')->name('update');

/* INFORME */
Route::get('Informe', [InformeController::class, 'informe'])->middleware('auth')->name('informe');

/* USUARIO */
Route::get('Información-Usuario', [UserController::class, 'usuario'])->middleware('auth')->name('usuario');

Route::post('Información-Usuario/{user}', [UserController::class, 'updateInfo'])->middleware('auth')->name('updateInfo');


Route::get('Editar-Informacion', [UserController::class, 'actualizar'])->middleware('auth')->name('actualizar');

Route::post('Editar-Informacion/{user}', [UserController::class, 'updateUser'])->middleware('auth')->name('updateUser');

Route::get('Agregar-Usuarios', [UserController::class, 'agregar'])->middleware('auth')->name('agregar');

Route::get('Listado-Usuarios', [UserController::class, 'listado'])->middleware('auth')->name('listado');

/* DESCARGA PDF */

Route::get('Donwload-PDF/{aprendiz}', [descargaController::class, 'donwload'])->middleware('auth')->name('donwload');

Route::get('Donwload/{teacher}', [descargaController::class, 'descargap'])->middleware('auth')->name('descargap');

Route::get('Descarga-PDF/{mes}', [descargaController::class, 'descargar'])->middleware('auth')->name('descargar');

/* Route::get('Descarga-PDF/{aprendiz}', [descargaController::class, 'descarga'])->middleware('auth')->name('descarga'); */

Route::get('DescargaInforme', [descargaController::class, 'informedescarga'])->middleware('auth')->name('informedescarga');

/* Historial */
Route::get('Historial', [AuthenticationController::class, 'historial'])->middleware('auth')->name('historial');

/* COMPROBANTE */ 

Route::get('Comprobante/{teacher}', [TeacherController::class, 'comprobante'])->middleware('auth')->name('comprobante');

Route::get('/mercadopago/success',  [AuthController::class, 'capturePayment'])->name('payment.success');

Route::get('/mercadopago/cancel', [AuthController::class, 'cancelPayment'])->name('payment.failure');

/* ESTADO DE LA CUENTA */

Route::get('Estado-Cuenta/{aprendiz}', [ApprenticeController::class, 'estado'])->middleware('auth')->name('estadoCuenta');

Route::get('Descarga-Informe/{estudiante}', [descargaController::class, 'descargarInforme'])->middleware('auth')->name('descargarInforme');

/* ASISTENCIA */

Route::get('Resgistro-Asistencias/{userId}', [AsistenciaController::class, 'asistencias'])->middleware('auth')->name('asistencias');

Route::get('descargar-Asistencias/{teacher}/{date}/{grupo}', [AsistenciaController::class, 'descargar'])->middleware('auth')->name('descargarAsistencias');


/* SERVICIOS */

Route::get('Servicios', [ServiceController::class, 'index'])->middleware('auth')->name('servicios');

Route::get('Enviar-Email', [ApprenticeController::class, 'sendEmail'])->middleware('auth')->name('sendEmail');

Route::get('Enviando email', [ApprenticeController::class, 'send'])->middleware('auth')->name('send');

