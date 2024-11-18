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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'max:255',
            'status' => 'required|in:En Progreso,Completado,Pendiente'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => "failed"
            ];
            return response()->json($data, 400);
        }

        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ]);

        if (!$task) {
            $data = [
                'message' => 'Error al crear la tarea',
                'status' => "error"
            ];
            return response()->json($data, 500);
        }

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
        $task = Task::find($id);

        if (!$task) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => "not-found"
            ];
            return response()->json($data, 404);
        }

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
        $task = Task::find($id);

        if (!$task) {
            $data = [
                'message' => 'Tarea no encontrado',
                'status' => "not-found"
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'max:255',
            'status' => 'required|in:En Progreso,Completado,Pendiente'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => "failed"
            ];
            return response()->json($data, 400);
        }

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
        $task = Task::find($id);

        if (!$task) {
            $data = [
                'message' => 'Tarea no encontrado',
                'status' => "not-found"
            ];
            return response()->json($data, 404);
        }
        
        $task->delete();

        $data = [
            'message' => 'Tarea eliminada',
            'status' => "success"
        ];

        return response()->json($data, 200);
    }
}
