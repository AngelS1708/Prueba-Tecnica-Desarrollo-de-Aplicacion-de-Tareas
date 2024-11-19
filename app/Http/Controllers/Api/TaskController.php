<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Guardado de todas las tareas en una variable data
        $tasks = Task::all();
        $data = [
            'tasks' => $tasks,
            'status' => "success"
        ];

        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validacion de los campos del request
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'max:255',
            'status' => 'required|in:En Progreso,Completado,Pendiente'
        ]);
        
        // Si algun campo no cumple los requisitos, se manda un mensaje de error
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => "failed"
            ];
            return response()->json($data, 400);
        }

        // Se crea la tarea con los campos obtenidos del request
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ]);
        
        // Si no se pudo crear la tarea, mandamos mensaje de error
        if (!$task) {
            $data = [
                'message' => 'Error al crear la tarea',
                'status' => "error"
            ];
            return response()->json($data, 500);
        }

        // Guardamos la tarea en una variable data y la retornamos
        $data = [
            'task' => $task,
            'status' => "success"
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Se busca la tarea con el id en la tabla
        $task = Task::find($id);

        // Si no se encontro, mandamos mensaje de error
        if (!$task) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => "not-found"
            ];
            return response()->json($data, 404);
        }

        // Si no existio ningun error, mandamos la tarea encontrada
        $data = [
            'task' => $task,
            'status' => "success"
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Buscamos la tarea con el id en la tabla
        $task = Task::find($id);

        // Si no se encontro, mandamos mensaje de error
        if (!$task) {
            $data = [
                'message' => 'Tarea no encontrado',
                'status' => "not-found"
            ];
            return response()->json($data, 404);
        }
        
        // Validamos que los campos editados cumplan los requisitos
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'max:255',
            'status' => 'required|in:En Progreso,Completado,Pendiente'
        ]);

        // Si algo fallo en la validacion, mandamos msj de error
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => "failed"
            ];
            return response()->json($data, 400);
        }

        // En caso de ningnu fallo, guardamos los cambios en la variable task y guardamos en la base de datos.
        $task->name = $request->name;
        $task->description = $request->description;
        $task->status = $request->status;

        $task->save();

        $data = [
            'message' => 'Tarea actualizada',
            'task' => $task,
            'status' => "success"
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscamos la tarea con el id en la tabla
        $task = Task::find($id);

        // Si no se encontro la tarea, mandamos mensaje de error
        if (!$task) {
            $data = [
                'message' => 'Tarea no encontrado',
                'status' => "not-found"
            ];
            return response()->json($data, 404);
        }
        
        // Si se pudo encontrar, eliminamos la tarea de la tabla y mandamos mensaje de exito
        $task->delete();

        $data = [
            'message' => 'Tarea eliminada',
            'status' => "success"
        ];

        return response()->json($data, 200);
    }
}
