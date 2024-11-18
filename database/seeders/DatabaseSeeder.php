<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Task::create([
            'name' => 'Examen Profesional',
            'description' => 'Se debera realizar el examen profesional de la asignatura correspondiente',
            'status' => 'En progreso',
        ]);

        \App\Models\Task::create([
            'name' => 'Creacion Base de datos',
            'description' => 'La creacion de la base de datos para el sistema web',
            'status' => 'En progreso',
        ]);

        \App\Models\Task::create([
            'name' => 'Tabla de materias',
            'description' => 'Creacion de la tabla de materias',
            'status' => 'Completado',
        ]);

        \App\Models\Task::create([
            'name' => 'Examen Tecnico',
            'description' => 'Creacion del examen tecnico',
            'status' => 'Pendiente',
        ]);


    }
}
