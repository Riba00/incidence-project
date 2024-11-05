<?php

namespace Tests\Feature;

use App\Livewire\CreateIncidenceForm;
use App\Livewire\DeleteIncidenceForm;
use App\Livewire\EditIncidenceForm;
use App\Livewire\ShowIncidence;
use App\Models\Incidence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IncidenceTest extends TestCase
{
    use RefreshDatabase;

    // CREATE INCIDENCE TESTS
    public function test_it_loads_support_users_on_mount()
    {
        Role::firstOrCreate(['name' => 'support']);

        $supportUser = User::factory()->create();
        $supportUser->assignRole('support');

        Livewire::test(CreateIncidenceForm::class)
            ->assertSet('users', function ($users) use ($supportUser) {
                return $users->contains($supportUser);
            });
    }

    public function test_admin_can_create_an_incidence()
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'support']);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        Livewire::test(CreateIncidenceForm::class)
            ->set('title', 'New Incidence')
            ->set('description', 'Description of the incidence')
            ->set('status', 'todo')
            ->set('user_id', $admin->id)
            ->call('submit')
            ->assertSessionHas('message', 'Incidence created successfully.')
            ->assertRedirect(route('incidences.index'));

        $this->assertDatabaseHas('incidences', [
            'title' => 'New Incidence',
            'description' => 'Description of the incidence',
            'status' => 'todo',
            'user_id' => $admin->id,
        ]);
    }

    public function test_support_user_can_create_an_incidence_assigned_to_themselves()
    {
        Role::firstOrCreate(['name' => 'support']);

        $supportUser = User::factory()->create();
        $supportUser->assignRole('support');

        $this->actingAs($supportUser);

        Livewire::test(CreateIncidenceForm::class)
            ->set('title', 'New Incidence')
            ->set('description', 'Description of the incidence')
            ->set('status', 'doing')
            ->call('submit')
            ->assertSessionHas('message', 'Incidence created successfully.')
            ->assertRedirect(route('incidences.index'));

        $this->assertDatabaseHas('incidences', [
            'title' => 'New Incidence',
            'description' => 'Description of the incidence',
            'status' => 'doing',
            'user_id' => $supportUser->id,
        ]);
    }

    public function test_validation_fails_if_required_fields_are_missing_create()
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'support']);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        Livewire::test(CreateIncidenceForm::class)
            ->set('title', '')
            ->set('status', '')
            ->set('user_id', '')
            ->call('submit')
            ->assertHasErrors(['title' => 'required', 'status' => 'required', 'user_id' => 'required']);
    }


    // SHOW INCIDENCE TESTS
    public function test_admin_can_view_any_incidence()
    {
        $adminUser = User::factory()->create();
        Role::findOrCreate('admin');
        $adminUser->assignRole('admin');

        $supportUser = User::factory()->create();
        Role::create(['name' => 'support']);
        $supportUser->assignRole('support');

        $incidence = Incidence::create([
            'title' => 'Test Incidence',
            'status' => 'todo',
            'description' => 'Test description',
            'user_id' => $supportUser->id,
        ]);

        $this->actingAs($adminUser);

        Livewire::test(ShowIncidence::class, ['id' => $incidence->id])
            ->assertSet('incidence.id', $incidence->id)
            ->assertSet('incidence.user_id', $supportUser->id);
    }

    public function test_non_admin_user_can_view_only_their_own_incidence()
    {
        $user = User::factory()->create();

        $incidence = Incidence::create([
            'title' => 'Test Incidence2',
            'status' => 'todo',
            'description' => 'Test description',
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        Livewire::test(ShowIncidence::class, ['id' => $incidence->id])
            ->assertSet('incidence.id', $incidence->id)
            ->assertSet('incidence.user_id', $user->id);
    }

    public function test_non_admin_user_is_redirected_if_incidence_does_not_belong_to_them()
    {
        $user = User::factory()->create();

        $otherUser = User::factory()->create();
        $incidence = Incidence::create([
            'title' => 'Test Incidence',
            'status' => 'todo',
            'description' => 'Test description',
            'user_id' => $otherUser->id,
        ]);

        $this->actingAs($user);

        Livewire::test(ShowIncidence::class, ['id' => $incidence->id])
            ->assertRedirect(route('incidences.index'));
    }

    public function test_it_redirects_if_incidence_does_not_exist_show()
    {
        $admin = User::factory()->create();
        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $this->actingAs($admin);

        Livewire::test(ShowIncidence::class, ['id' => 999])
            ->assertRedirect(route('incidences.index'));
    }


    // EDIT INCIDENCE TESTS
    public function test_admin_can_load_incidence()
    {
        $admin = User::factory()->create();
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'support']);
        $admin->assignRole('admin');

        $incidence = Incidence::create([
            'title' => 'Test Incidence',
            'status' => 'todo',
            'description' => 'Test description',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin);

        Livewire::test(EditIncidenceForm::class, ['id' => $incidence->id])
            ->assertSet('title', $incidence->title)
            ->assertSet('description', $incidence->description)
            ->assertSet('status', $incidence->status)
            ->assertSet('user_id', $incidence->user_id);
    }

    public function test_unauthorized_user_is_redirected_if_incidence_does_not_belong_to_them()
    {
        $user = User::factory()->create();
        Role::create(['name' => 'support']);

        $otherUser = User::factory()->create();
        $incidence = Incidence::create([
            'title' => 'Test Incidence',
            'status' => 'todo',
            'description' => 'Test description',
            'user_id' => $otherUser->id,
        ]);

        $this->actingAs($user);

        Livewire::test(EditIncidenceForm::class, ['id' => $incidence->id])
            ->assertRedirect(route('incidences.index'));
    }

    public function test_validation_fails_if_required_fields_are_missing_edit()
    {
        $admin = User::factory()->create();
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'support']);
        $admin->assignRole('admin');

        $incidence = Incidence::create([
            'title' => 'Test Incidence',
            'status' => 'todo',
            'description' => 'Test description',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin);

        Livewire::test(EditIncidenceForm::class, ['id' => $incidence->id])
            ->set('title', '')
            ->set('status', '')
            ->call('submit')
            ->assertHasErrors(['title' => 'required', 'status' => 'required']);
    }

    public function test_support_user_can_update_only_status()
    {
        $supportUser = User::factory()->create();
        Role::create(['name' => 'support']);
        $supportUser->assignRole('support');

        $incidence = Incidence::create([
            'title' => 'Test Incidence',
            'status' => 'todo',
            'description' => 'Test description',
            'user_id' => $supportUser->id,
        ]);

        $this->actingAs($supportUser);

        Livewire::test(EditIncidenceForm::class, ['id' => $incidence->id])
            ->set('status', 'doing')
            ->call('submit')
            ->assertSessionHas('message', 'Incidence updated successfully!')
            ->assertRedirect(route('incidences.show', $incidence->id));

        $this->assertDatabaseHas('incidences', [
            'id' => $incidence->id,
            'status' => 'doing',
            'title' => $incidence->title,
            'description' => $incidence->description,
            'user_id' => $incidence->user_id,
        ]);
    }

    public function test_admin_can_update_all_fields()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'support']);
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $incidence = Incidence::create([
            'title' => 'Test Incidence',
            'status' => 'todo',
            'description' => 'Test description',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin);

        Livewire::test(EditIncidenceForm::class, ['id' => $incidence->id])
            ->set('title', 'Updated Title')
            ->set('description', 'Updated Description')
            ->set('status', 'done')
            ->set('user_id', $admin->id)
            ->call('submit')
            ->assertSessionHas('message', 'Incidence updated successfully!')
            ->assertRedirect(route('incidences.show', $incidence->id));

        $this->assertDatabaseHas('incidences', [
            'id' => $incidence->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'status' => 'done',
            'user_id' => $admin->id,
        ]);
    }

    // DELETE INCIDENCE TESTS
    public function test_non_admin_user_is_redirected()
    {
        $supportUser = User::factory()->create();
        $incidence = Incidence::create([
            'title' => 'Test Incidence',
            'status' => 'todo',
            'description' => 'Test description',
            'user_id' => $supportUser->id,
        ]);

        $this->actingAs($supportUser);

        Livewire::test(DeleteIncidenceForm::class, ['id' => $incidence->id])
            ->assertRedirect(route('incidences.index'));
    }

    public function test_it_redirects_if_incidence_does_not_exist_delete()
    {
        $admin = User::factory()->create();
        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $this->actingAs($admin);

        Livewire::test(DeleteIncidenceForm::class, ['id' => 999])
            ->assertRedirect(route('incidences.index'));
    }

    public function test_incidence_is_deleted_when_confirmation_text_matches()
    {
        $adminUser = User::factory()->create();
        Role::create(['name' => 'admin']);
        $adminUser->assignRole('admin');

        $supportUser = User::factory()->create();
        Role::create(['name' => 'support']);
        $supportUser->assignRole('support');

        $this->actingAs($adminUser);

        $incidence = Incidence::create([
            'title' => 'Test Incidence',
            'status' => 'todo',
            'description' => 'Test description',
            'user_id' => $supportUser->id,
        ]);

        Livewire::test(DeleteIncidenceForm::class, ['id' => $incidence->id])
            ->set('confirmationText', 'Test Incidence')
            ->call('submit')
            ->assertSessionHas('message', 'Incidence deleted successfully!')
            ->assertRedirect(route('incidences.index'));

        $this->assertDatabaseMissing('incidences', ['id' => $incidence->id]);
    }

    public function test_incidence_is_not_deleted_when_confirmation_text_does_not_match()
    {
        $adminUser = User::factory()->create();
        Role::create(['name' => 'admin']);
        $adminUser->assignRole('admin');

        $supportUser = User::factory()->create();
        Role::create(['name' => 'support']);
        $supportUser->assignRole('support');

        $this->actingAs($adminUser);

        $incidence = Incidence::create([
            'title' => 'Test Incidence',
            'status' => 'todo',
            'description' => 'Test description',
            'user_id' => $supportUser->id,
        ]);

        Livewire::test(DeleteIncidenceForm::class, ['id' => $incidence->id])
            ->set('confirmationText', 'Wrong Text')
            ->call('submit')
            ->assertHasErrors(['confirmationText' => 'The entered text does not match the incidence title.']);

        $this->assertDatabaseHas('incidences', ['id' => $incidence->id]);
    }

}
