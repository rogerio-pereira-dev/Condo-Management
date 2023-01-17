<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
                    'password' => 'Admin@2023',
                    'confirmation' => 'Admin@2023',
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
                    'password' => 'Maintenance@2023',
                    'confirmation' => 'Maintenance@2023',
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
                    'password' => 'Tenant@2023',
                    'confirmation' => 'Tenant@2023',
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
            'validation_nullable' => [
                'data' => [
                    'name' => 'User Tenant 2',
                    'email' => 'tenant2@user.com',
                    'password' => 'Tenant@2023',
                    'confirmation' => 'Tenant@2023',
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
            'validaton_required' => [
                'data' => [],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'name' => ['The name field is required.'],
                        'email' => ['The email field is required.'],
                        'password' => ['The password field is required.'],
                    ]
                ]
            ],
            'validaton_email' => [
                'data' => [
                    'email' => 'email',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'email' => ['The email must be a valid email address.'],
                    ]
                ]
            ],
            'validaton_email_2' => [
                'data' => [
                    'email' => 'email@',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'email' => ['The email must be a valid email address.'],
                    ]
                ]
            ],
            'validaton_same' => [
                'data' => [
                    'password' => 'password',
                    'confirmation' => 'wrong',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'confirmation' => ['The confirmation and password must match.'],
                    ]
                ]
            ],
            'validaton_password' => [
                'data' => [
                    'password' => 'pass',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'password' => [
                            "The password must be at least 8 characters.",
                            "The password must contain at least one uppercase and one lowercase letter.",
                            "The password must contain at least one symbol.",
                            "The password must contain at least one number."
                        ],
                    ]
                ]
            ],
            'validaton_in' => [
                'data' => [
                    'role' => 'admin',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'role' => [
                            "The selected role is invalid.",
                        ],
                    ]
                ]
            ],
            'validaton_in_2' => [
                'data' => [
                    'role' => 'maintenance',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'role' => [
                            "The selected role is invalid.",
                        ],
                    ]
                ]
            ],
            'validaton_in_3' => [
                'data' => [
                    'role' => 'tenant',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'role' => [
                            "The selected role is invalid.",
                        ],
                    ]
                ]
            ],
        ];
    }

    /**
     * Test Create User
     * 
     * @dataProvider createDataProvider
     */
    public function testCreateUser($data, $status, $json)
    {
        $this->actingAs(self::$user)
            ->postJson(self::URL, $data)
            ->assertStatus($status)
            ->assertJson($json);

        //Make sure user can log in
        if($status == 201) {
            $this->assertDatabaseHas('users', $json['user']);

            $this->checkPasswordHash($data);

            $this->logout();

            $this->login($data);
        }
    }

    /**
     * Check if Password Hash is valid
     *
     * @param [type] $data
     * @return void
     */
    private function checkPasswordHash($data)
    {
        $user = User::where('name', $data['name'])
                    ->where('email', $data['email'])
                    ->first()
                    ->makeVisible('password');
        $hashMatches = Hash::check($data['password'], $user->password);

        $this->assertTrue($hashMatches);
    }

    /**
     * Logout system
     *
     * @return void
     */
    private function logout()
    {
        $this->postJson('/api/logout', [])
            ->assertStatus(200);
        $this->assertTrue(Auth::guest());
    }

    /**
     * Login using provided credentials
     *
     * @param array $data
     * @return void
     */
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
