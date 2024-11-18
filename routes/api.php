<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::apiResource('tasks', TaskController::class);

Route::get('/tasks', [TaskController::class, 'index']);         // Lista todas las tareas
Route::get('/tasks/{id}', [TaskController::class, 'show']);     // Muestra una tarea específica
Route::post('/tasks', [TaskController::class, 'store']);        // Crea una nueva tarea
Route::put('/tasks/{id}', [TaskController::class, 'update']);   // Actualiza una tarea existente
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // Elimina una tarea

