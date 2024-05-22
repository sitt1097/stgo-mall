<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

use Illuminate\Support\Facades\DB;

try {
    DB::connection()->getPdo();
    echo "La conexión a la base de datos fue exitosa.\n";
    
    // Ejemplo de consulta
    $results = DB::table('Personas')->get();
    print_r($results);
} catch (\Exception $e) {
    echo "Error al intentar conectar a la base de datos: " . $e->getMessage() . "\n";
}
