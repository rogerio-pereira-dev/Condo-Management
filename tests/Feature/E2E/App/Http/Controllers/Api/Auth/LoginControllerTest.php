<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    CONST URL = '/api/login';

    public function loginDataProvider() : array
    {
        return [
            'login_ok' => [
                'credentials' => [
                    'email' => 'admin@user.com',
                    'password' => 'password',
                ],
                'status' => 200,
                'jsonStructure' => [
                    'message',
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ]
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
                    'email' => 'admin@user.com',
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
