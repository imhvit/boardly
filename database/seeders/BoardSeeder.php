<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Column;
use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Garantizar un usuario para evitar el fallo de Auth::id() en CLI
        $owner = User::first() ?? User::factory()->create([
            'name' => 'Admin System',
            'email' => 'admin@system.local',
        ]);

        // Autenticamos al usuario para que el evento creating() del Board funcione
        Auth::login($owner);

        // 2. Usar transacciones para evitar datos huérfanos si el proceso falla a la mitad
        DB::transaction(function () use ($owner) {

            // Creación del Tablero Principal
            $board = Board::create([
                'title' => 'Boardly MVP Development',
                'description' => 'Tablero principal para el seguimiento de sprints y backlog del producto.',
                'tag' => 'engineering',
                'visibility' => 'public',
            ]);

            // Asignar el tablero a algunos usuarios extra (Relación N:M)
            $teamMembers = User::factory(3)->create();
            $board->users()->attach($teamMembers->pluck('id'));

            // 3. Creación de Columnas (Pipeline estándar de Kanban)
            $columnsData = [
                ['name' => 'Backlog', 'position' => 0],
                ['name' => 'To Do', 'position' => 1],
                ['name' => 'In Progress', 'position' => 2],
                ['name' => 'Done', 'position' => 3],
            ];

            $columns = collect($columnsData)->map(function ($data) use ($board) {
                return $board->columns()->create($data); // Usando la relación para inyectar board_id
            });

            // 4. Creación de Tareas y asignaciones
            $this->seedCards($columns, $owner, $teamMembers);
        });

        // Limpiar la autenticación CLI por seguridad en el resto de seeders
        Auth::logout();
    }

    /**
     * Extrae la lógica de creación de tareas para mantener el método run() limpio (Clean Code)
     */
    private function seedCards($columns, User $owner, $teamMembers): void
    {
        // Extraemos las columnas específicas para distribuir tareas
        $backlog = $columns->firstWhere('name', 'Backlog');
        $inProgress = $columns->firstWhere('name', 'In Progress');
        $done = $columns->firstWhere('name', 'Done');

        // Tarea en Backlog
        $card1 = $backlog->cards()->create([
            'title' => 'Diseñar arquitectura de Base de Datos',
            'description' => 'Normalización y creación de diagramas E-R.',
            'is_completed' => false,
            'end_date' => now()->addDays(5),
            // 'owner_id' => $owner->id // Descomentar si tu BD lo exige y lo agregas al $fillable
        ]);
        $card1->users()->attach($teamMembers->random()->id); // Asignar a un dev aleatorio

        // Tarea en In Progress
        $card2 = $inProgress->cards()->create([
            'title' => 'Implementar autenticación Sanctum/Inertia',
            'description' => 'Configurar middleware y guards para la SPA.',
            'is_completed' => false,
            'end_date' => now()->addDays(2),
        ]);
        $card2->users()->attach([$owner->id, $teamMembers->first()->id]); // Pair programming

        // Tarea en Done
        $done->cards()->create([
            'title' => 'Configurar CI/CD Pipeline',
            'description' => 'Acciones de GitHub para testing automático y linting.',
            'is_completed' => true,
            'end_date' => now()->subDays(1),
        ]);
    }
}
