<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CREATE ADMIN USER AND ASIGN ROLE
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12341234'),
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $adminUser->assignRole($adminRole);

        // CREATE SUPPORT USERS AND ASIGN ROLE
        $supportUser1 = User::create([
            'name' => 'Support1',
            'email' => 'support1@support.com',
            'password' => bcrypt('12341234'),
        ]);

        $supportUser2 = User::create([
            'name' => 'Support2',
            'email' => 'support2@support.com',
            'password' => bcrypt('12341234'),
        ]);

        $supportRole = Role::where('name', 'support')->first();

        $supportUser1->assignRole($supportRole);
        $supportUser2->assignRole($supportRole);
    }
}
