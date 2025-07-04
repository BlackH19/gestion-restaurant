<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

    

    \App\Models\User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@restaurant.com',
        'password' => bcrypt('password'),
        'role' => 'admin'
    ]);

    \App\Models\User::factory()->create([
        'name' => 'Caissier',
        'email' => 'caissier@restaurant.com',
        'password' => bcrypt('password'),
        'role' => 'caissier'
    ]);

    \App\Models\User::factory()->create([
        'name' => 'Serveur',
        'email' => 'serveur@restaurant.com',
        'password' => bcrypt('password'),
        'role' => 'serveur'
    ]);
    $this->call(RolePermissionSeeder::class);
}
}

