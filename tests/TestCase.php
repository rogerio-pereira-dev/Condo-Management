<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected $userAdmin;
    protected $userMaintenance;
    protected $userTenant;

    public function setUp() : void
    {
        parent::setUp();

        $this->seedDatabase();
        $this->checkDatabase();

        $this->withoutVite();
    }

    /**
     * Add 3 users (Admin, Maintenance, Tenant)
     *
     * @return void
     */
    private function seedDatabase()
    {
        $this->userAdmin  = User::factory()->create([
            'name' => 'User Admin',
            'email' => 'admin@user.com',
            'role' => 'Admin'
        ]);
        $this->userMaintenance = User::factory()->create([
                'name' => 'User Maintenance',
                'email' => 'maintenance@user.com',
                'role' => 'Maintenance'
            ]);
        $this->userTenant = User::factory()->create([
                'name' => 'User Tenant',
                'email' => 'tenat@user.com',
                'role' => 'Tenant'
            ]);
    }

    /**
     * check all users were created
     *
     * @return void
     */
    private function checkDatabase()
    {
        $this->assertDatabaseHas('users', [
            'id' => 1,
            'name' => 'User Admin',
            'email' => 'admin@user.com',
            'role' => 'Admin'
        ]);
        $this->assertDatabaseHas('users', [
            'id' => 2,
            'name' => 'User Maintenance',
            'email' => 'maintenance@user.com',
            'role' => 'Maintenance'
        ]);
        $this->assertDatabaseHas('users', [
            'id' => 3,
            'name' => 'User Tenant',
            'email' => 'tenat@user.com',
            'role' => 'Tenant'
        ]);
    }
}
