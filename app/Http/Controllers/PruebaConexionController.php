<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PruebaConexionController extends Controller
{
    public function probarConexion()
    {
        try {
            DB::connection()->getPdo();
            return "La conexión a la base de datos fue exitosa.";
        } catch (\Exception $e) {
            return "Error al intentar conectar a la base de datos: " . $e->getMessage();
        }
    }
}