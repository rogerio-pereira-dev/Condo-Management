<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Api\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\ChangePasswordMail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChangePasswordControllerTest extends TestCase
{
    CONST URL = '/api/user/change-password';
    protected $credentials;

    public function setUp() : void
    {
        parent::setUp();

        $this->credentials = [
            'email' => 'admin@user.com',
            'password' => 'password',
        ];
    }

    public function changePasswordProvider() : array
    {
        return [
            'ok' => [
                'data' => [
                    'current_password' => 'password',
                    'new_password' => 'newPassword@123',
                    'confirmation' => 'newPassword@123',
                ],
                'status' => 200,
                'json' => [
                    'message' => 'Password changed.'
                ]
            ],
            'validation_required' => [
                'data' => [],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'current_password' => ['The current password field is required.'],
                        'new_password' => ['The new password field is required.'],
                        'confirmation' => ['The confirmation field is required.'],
                    ]
                ]
            ],
            'validation_same' => [
                'data' => [
                    'new_password' => 'new_password',
                    'confirmation' => 'confirmation',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'confirmation' => ['The confirmation and new password must match.'],
                    ]
                ]
            ],
            'validaton_password' => [
                'data' => [
                    'new_password' => 'pass',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'new_password' => [
                            "The new password must be at least 8 characters.",
                            "The new password must contain at least one uppercase and one lowercase letter.",
                            "The new password must contain at least one symbol.",
                            "The new password must contain at least one number."
                        ],
                    ]
                ]
            ],
        ];
    }
    public function requestPasswordChangeProvider() : array
    {
        return [
            'ok' => [
                'userId' => 3,
                'status' => 200,
                'json' => [
                    'message' => 'Email requesting password change sent.'
                ]
            ],
            'wrong_user' => [
                'userId' => 999,
                'status' => 404,
                'json' => []
            ],
            'validation_required' => [
                'user_id' => null,
                'status' => 422,
                'json' => [
                    'errors' => [
                        'user_id' => ['The user id field is required.']
                    ]
                ]
            ],
            'validation_numeric' => [
                'user_id' => 'id',
                'status' => 422,
                'json' => [
                    'errors' => [
                        'user_id' => ['The user id must be a number.']
                    ]
                ]
            ],
        ];
    }


    /**
     * Test Update User
     * 
     * @dataProvider changePasswordProvider
     */
    public function testUpdateUser($data, $status, $json)
    {
        $this->checkPasswordHash($this->credentials['password']);
        $this->login($this->credentials);

        $this->postJson(self::URL, $data)
            ->assertStatus($status)
            ->assertJson($json);

        $this->logout();

        if($status == 200) {
            $this->credentials['password'] = $data['new_password'];
        }

        $this->checkPasswordHash($this->credentials['password']);
        $this->login($this->credentials);
    }

    /**
     * Test Update User
     * 
     * @dataProvider requestPasswordChangeProvider
     */
    public function testRequestPasswordChange($userId, $status, $json)
    {
        Mail::fake();

        $this->assertDatabaseMissing('users', [
            'id' => 999,
        ]);
        
        $this->actingAs($this->userAdmin)
            ->postJson(self::URL.'/request', [
                'user_id' => $userId
            ])
            ->assertStatus($status)
            ->assertJson($json);
        
        if($status == 200) {
            $to = $this->userTenant;
            $subject = config('app.name').' - Requested to Change Password';

            Mail::assertSent(ChangePasswordMail::class, function ($mail) use ($to, $subject) {
                return  $mail->hasTo($to->email) &&
                        $mail->hasSubject($subject);
            });
        }
        else {
            Mail::assertNotSent(ChangePasswordMail::class);
        }
    }

    #region privateFunctions
    /**
     * Check if Password Hash is valid
     *
     * @param string $data
     * @return void
     */
    private function checkPasswordHash(string $password)
    {
        $user = User::where('id', 1)
                    ->first()
                    ->makeVisible('password');
        $hashMatches = Hash::check($password, $user->password);

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
    private function login(array $credentials)
    {
        $this->assertNull(Auth::user());

        $this->postJson('/api/login', $credentials)
                ->assertStatus(200);
        
        $logedUser = Auth::user(); 
        $this->assertEquals('admin@user.com', $logedUser->email);
    }
    #endregion
}
