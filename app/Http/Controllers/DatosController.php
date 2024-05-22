<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatosController extends Controller
{
    public function obtenerDatos()
    {
        try {
            // Ejecutar la consulta SQL para obtener los datos de la tabla personas
            $personas = DB::select('SELECT nombre, apellido, edad FROM personas');

            // Devolver los datos en formato JSON
            return response()->json($personas);
        } catch (\Exception $e) {
            // Manejar cualquier error que ocurra durante la consulta
            return response()->json(['error' => 'Error al obtener los datos: ' . $e->getMessage()], 500);
        }
    }

    public function obtenerGuiaTelefonica()
    {
        try {
            // Obtener los datos de la tabla guia_telefonica
            $guia = DB::table('guia_telefonica')->select('ubicacion_local', 'nombre_local', 'telefono_local')->get();

            // Devolver los datos en formato JSON
            return response()->json($guia);
        } catch (\Exception $e) {
            // Manejar cualquier error que ocurra durante la consulta
            return response()->json(['error' => 'Error al obtener los datos: ' . $e->getMessage()], 500);
        }
    }

    public function crearEntradaGuia(Request $request)
    {
        try {
            // Validar que el request tenga un array de entradas
            $validatedData = $request->validate([
                'entradas' => 'required|array',
                'entradas.*.ubicacion_local' => 'required|string|max:255',
                'entradas.*.nombre_local' => 'required|string|max:255',
                'entradas.*.telefono_local' => 'required|string|max:255',
            ]);

            // Recorrer cada entrada y guardarla en la base de datos
            foreach ($validatedData['entradas'] as $entrada) {
                DB::table('guia_telefonica')->insert([
                    'ubicacion_local' => $entrada['ubicacion_local'],
                    'nombre_local' => $entrada['nombre_local'],
                    'telefono_local' => $entrada['telefono_local'],
                ]);
            }

            // Devolver una respuesta exitosa
            return response()->json(['message' => 'Entradas creadas exitosamente.'], 201);
        } catch (\Exception $e) {
            // Manejar cualquier error que ocurra durante la inserción
            return response()->json(['error' => 'Error al crear las entradas: ' . $e->getMessage()], 500);
        }
    }

    public function buscarPorId(Request $request)
    {
        try {
            // Obtener el valor del parámetro 'id' de la solicitud
            $id = $request->query('id');

            // Verificar si se proporcionó el ID
            if ($id) {
                // Ejecutar la consulta SQL para buscar por ID
                $entrada = DB::table('guia_telefonica')->where('id', $id)->first();

                // Verificar si se encontró la entrada
                if ($entrada) {
                    return response()->json($entrada);
                } else {
                    return response()->json(['message' => 'No se encontró ninguna entrada con el ID proporcionado.'], 404);
                }
            } else {
                // No se proporcionó el ID, devolver un error
                return response()->json(['error' => 'El parámetro "id" es requerido en la consulta.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al buscar por ID: ' . $e->getMessage()], 500);
        }
    }

    
    public function buscarPorLocal(Request $request)
    {
        try {
            // Verificar si se proporcionó el parámetro 'local'
            if ($request->has('local')) {
                // Obtener el valor del parámetro 'local' de la solicitud
                $local = $request->query('local');

                // Ejecutar la consulta SQL para buscar por local
                $entradas = DB::table('guia_telefonica')->where('ubicacion_local', 'like', '%' . $local . '%')->get();

                // Verificar si se encontraron entradas
                if ($entradas->isEmpty()) {
                    return response()->json(['message' => 'No se encontraron entradas con el nombre del local proporcionado.'], 404);
                } else {
                    return response()->json($entradas);
                }
            } else {
                // No se proporcionó el parámetro 'local', devolver un error
                return response()->json(['error' => 'El parámetro "local" es requerido en la consulta.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al buscar por local: ' . $e->getMessage()], 500);
        }
    }

    public function buscarPorLocal_Nombre(Request $request)
    {
        try {
            // Verificar si se proporcionó el parámetro 'local'
            if ($request->has('name')) {
                // Obtener el valor del parámetro 'local' de la solicitud
                $name = $request->query('name');

                // Ejecutar la consulta SQL para buscar por local
                $entradas = DB::table('guia_telefonica')->where('nombre_local', 'like', '%' . $name . '%')->get();

                // Verificar si se encontraron entradas
                if ($entradas->isEmpty()) {
                    return response()->json(['message' => 'No se encontraron entradas con el nombre del local proporcionado.'], 404);
                } else {
                    return response()->json($entradas);
                }
            } else {
                // No se proporcionó el parámetro 'local', devolver un error
                return response()->json(['error' => 'El parámetro "local" es requerido en la consulta.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al buscar por local: ' . $e->getMessage()], 500);
        }
    }


}
