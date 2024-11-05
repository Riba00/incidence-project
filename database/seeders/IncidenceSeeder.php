<?php

namespace Database\Seeders;

use App\Models\Incidence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Incidence::create([
            'title' => 'Incidence 1',
            'description' => 'Description 1',
            'status' => 'todo',
            'user_id' => 1
        ]);

        Incidence::create([
            'title' => 'Incidence 2',
            'description' => 'Description 2',
            'status' => 'todo',
            'user_id' => 1
        ]);

        Incidence::create([
            'title' => 'Incidence 3',
            'description' => 'Description 3',
            'status' => 'todo',
            'user_id' => 2
        ]);

        Incidence::create([
            'title' => 'Incidence 4',
            'description' => 'Description 4',
            'status' => 'doing',
            'user_id' => 2
        ]);

        Incidence::create([
            'title' => 'Incidence 5',
            'description' => 'Description 5',
            'status' => 'doing',
            'user_id' => 2
        ]);

        Incidence::create([
            'title' => 'Incidence 6',
            'description' => 'Description 6',
            'status' => 'done',
            'user_id' => 2
        ]);
    }
}
