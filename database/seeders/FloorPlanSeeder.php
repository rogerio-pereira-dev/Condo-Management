<?php

namespace Database\Seeders;

use App\Models\FloorPlan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FloorPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FloorPlan::factory(5)->create();
    }
}
