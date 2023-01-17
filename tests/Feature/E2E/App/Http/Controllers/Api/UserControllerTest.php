<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    CONST URL = '/api/user';

    public function createDataProvider() : array
    {
        return [
            'admin_ok' => [
                'data' => [
                    'name' => 'User Admin',
                    'email' => 'admin@user.com',
                    'password' => 'admin',
                    'role' => 'Admin'
                ],
                'status' => 201,
                'json' => [
                    'message' => 'User created.',
                    'user' => [
                        'id' => 2,
                        'name' => 'User Admin',
                        'email' => 'admin@user.com',
                        'role' => 'Admin'
                    ]
                ]
            ],
            'maintenance_ok' => [
                'data' => [
                    'name' => 'User Maintenance',
                    'email' => 'maintenance@user.com',
                    'password' => 'maintenance',
                    'role' => 'Maintenance'
                ],
                'status' => 201,
                'json' => [
                    'message' => 'User created.',
                    'user' => [
                        'id' => 3,
                        'name' => 'User Maintenance',
                        'email' => 'maintenance@user.com',
                        'role' => 'Maintenance'
                    ]
                ]
            ],
            'tenant_ok' => [
                'data' => [
                    'name' => 'User Tenant',
                    'email' => 'tenant@user.com',
                    'password' => 'tenant',
                    'role' => 'Tenant'
                ],
                'status' => 201,
                'json' => [
                    'message' => 'User created.',
                    'user' => [
                        'id' => 4,
                        'name' => 'User Tenant',
                        'email' => 'tenant@user.com',
                        'role' => 'Tenant'
                    ]
                ]
            ],
            'no_role_ok' => [
                'data' => [
                    'name' => 'User Tenant 2',
                    'email' => 'tenant2@user.com',
                    'password' => 'tenant',
                ],
                'status' => 201,
                'json' => [
                    'message' => 'User created.',
                    'user' => [
                        'id' => 5,
                        'name' => 'User Tenant 2',
                        'email' => 'tenant2@user.com',
                        'role' => 'Tenant'
                    ]
                ]
            ],
        ];
    }

    /**
     * @dataProvider createDataProvider
     */
    public function testCreateUser($data, $status, $json)
    {
        $this->actingAs(self::$user)
            ->postJson(self::URL, $data)
            ->assertStatus($status); 
        $this->assertDatabaseHas('users', $json['user']);

        //Make sure user can log in
        if($status == 201) {
            $this->logout();

            $this->login($data);
        }
    }

    private function logout()
    {
        $this->postJson('/api/logout', [])
            ->assertStatus(200);
        $this->assertTrue(Auth::guest());
    }

    private function login(array $data)
    {
        $credentials = [
            'email' => $data['email'],    
            'password' => $data['password'],    
        ];

        $this->postJson('/api/login', $credentials)
                ->assertStatus(200);
    }
}
