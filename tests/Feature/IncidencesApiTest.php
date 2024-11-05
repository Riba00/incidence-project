<?php

namespace Tests\Feature;

use App\Models\Incidence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IncidencesApiTest extends TestCase
{
    use RefreshDatabase;
    public function test_support_user_can_only_view_their_own_incidences()
    {
        Role::firstOrCreate(['name' => 'support']);

        $supportUser = User::factory()->create();
        $supportUser->assignRole('support');

        $otherUser = User::factory()->create();

        Incidence::create([
            'title' => 'Incidencia 1',
            'description' => 'Descripción 1',
            'status' => 'todo',
            'user_id' => $supportUser->id,
        ]);

        Incidence::create([
            'title' => 'Incidencia 2',
            'description' => 'Descripción 2',
            'status' => 'doing',
            'user_id' => $otherUser->id,
        ]);

        $this->actingAs($supportUser);

        $response = $this->getJson('/api/incidences');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['user_id' => $supportUser->id]);
    }

    public function test_admin_can_view_all_incidences()
    {
        Role::firstOrCreate(['name' => 'admin']);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        Incidence::create([
            'title' => 'Incidencia 1',
            'description' => 'Descripción 1',
            'status' => 'todo',
            'user_id' => $admin->id,
        ]);

        Incidence::create([
            'title' => 'Incidencia 2',
            'description' => 'Descripción 2',
            'status' => 'doing',
            'user_id' => $admin->id,
        ]);

        Incidence::create([
            'title' => 'Incidencia 3',
            'description' => 'Descripción 3',
            'status' => 'done',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin);

        $response = $this->getJson('/api/incidences');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_incidences_can_be_filtered_by_status()
    {
        Role::firstOrCreate(['name' => 'admin']);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        
        Incidence::create([
            'title' => 'Incidencia 1',
            'description' => 'Descripción 1',
            'status' => 'todo',
            'user_id' => $admin->id,
        ]);

        Incidence::create([
            'title' => 'Incidencia 2',
            'description' => 'Descripción 2',
            'status' => 'doing',
            'user_id' => $admin->id,
        ]);

        Incidence::create([
            'title' => 'Incidencia 3',
            'description' => 'Descripción 3',
            'status' => 'done',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin);

        $response = $this->getJson('/api/incidences?status=done');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['status' => 'done']);

        // Filtrar por múltiples estados
        $response = $this->getJson('/api/incidences?status=todo,doing');

        $response->assertStatus(200)
                 ->assertJsonCount(2)
                 ->assertJsonFragment(['status' => 'todo'])
                 ->assertJsonFragment(['status' => 'doing']);
    }

    public function test_unauthorized_user_cannot_access_incidences()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->getJson('/api/incidences');

        $response->assertStatus(403)
                 ->assertJson(['error' => 'Unauthorized role']);
    }
}
