<?php

namespace Tests\Feature\Integration\App\Http\Controllers\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    protected $user;

    CONST URL = '/api/login';

    public function setUp() : void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'test@user.com',
        ]);
    }

    public function loginDataProvider() : array
    {
        return [
            'login_ok' => [
                'credentials' => [
                    'email' => 'test@user.com',
                    'password' => 'password',
                ],
                'status' => 200,
                'jsonStructure' => [
                    'message' 
                ]
            ],
            'wrong_email' => [
                'credentials' => [
                    'email' => 'wrong@user.com',
                    'password' => 'password',
                ],
                'status' => 403,
                'jsonStructure' => [
                    'errors' => [
                        'email',
                    ]
                ]
            ],
            'wrong_password' => [
                'credentials' => [
                    'email' => 'test@user.com',
                    'password' => 'wrongpassword',
                ],
                'status' => 403,
                'jsonStructure' => [
                    'errors' => [
                        'email',
                    ]
                ]
            ],
            'doesnt_exist' => [
                'credentials' => [
                    'email' => 'new@user.com',
                    'password' => 'password',
                ],
                'status' => 403,
                'jsonStructure' => [
                    'errors' => [
                        'email',
                    ]
                ]
            ],
            'validation_required' => [
                'credentials' => [],
                'status' => 422,
                'jsonStructure' => [
                    'errors' => [
                        'email',
                        'password',
                    ]
                ]
            ],
            'validation_email' => [
                'credentials' => [
                    'email' => 'new',
                    'password' => 'password',
                ],
                'status' => 422,
                'jsonStructure' => [
                    'errors' => [
                        'email',
                    ]
                ]
            ],
            'validation_email2' => [
                'credentials' => [
                    'email' => 'new@',
                    'password' => 'password',
                ],
                'status' => 422,
                'jsonStructure' => [
                    'errors' => [
                        'email',
                    ]
                ]
            ],
        ];
    }

    /**
     * @dataProvider loginDataProvider
     */
    public function testLogin($credentials, $status, $jsonStructure)
    {
        $this->postJson(self::URL, $credentials)
            ->assertStatus($status)
            ->assertJsonStructure($jsonStructure);
    }
}
