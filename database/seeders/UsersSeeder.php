<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
                'name' => 'Rogerio Pereira',
                'email' => 'hi@rogeriopereira.dev',
                'password' => '$2y$10$HVuDYFwgYUeEaZls.pGauOuGkRItjkAqKViHa5X32mSK9p/UQHY3.',
                'role' => 'Admin'
            ]);

        //Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('admin'),
            'role' => 'Admin'
        ]);

        //Maintenance
        User::factory()->create([
                'name' => 'Maintenance User',
                'email' => 'maintenance@test.com',
                'password' => bcrypt('maintenance'),
                'role' => 'Maintenance'
            ]);

        //Tenant
        User::factory()->create([
                'name' => 'Tenant User',
                'email' => 'tenant@test.com',
                'password' => bcrypt('tenant'),
                'role' => 'Tenant'
            ]);
    }
}
