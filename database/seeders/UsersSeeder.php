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
        $user = User::factory()->create([
                        'name' => 'Rogerio Pereira',
                        'email' => 'hi@rogeriopereira.dev',
                        'password' => '$2y$10$HVuDYFwgYUeEaZls.pGauOuGkRItjkAqKViHa5X32mSK9p/UQHY3.'
                    ]);
    }
}
