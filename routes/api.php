<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('datos', [DatosController::class, 'obtenerDatos']);
Route::get('guia-telefonica', [DatosController::class, 'obtenerGuiaTelefonica']);
Route::post('guia-telefonica', [DatosController::class, 'crearEntradaGuia']);
Route::get('guia-telefonica/buscar-por-id', [DatosController::class, 'buscarPorId']);
Route::get('guia-telefonica/buscar-por-local', [DatosController::class, 'buscarPorLocal']);
Route::get('guia-telefonica/buscar-nombre-por-local', [DatosController::class, 'buscarPorLocal_Nombre']);

