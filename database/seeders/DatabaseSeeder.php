<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Crea 5 usuarios, cada uno con 3 tareas
        User::factory()
            ->count(5)
            ->has(Task::factory()->count(3))
            ->create();
    }
}
