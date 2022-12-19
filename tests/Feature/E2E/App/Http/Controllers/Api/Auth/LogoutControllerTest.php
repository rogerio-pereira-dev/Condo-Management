<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutControllerTest extends TestCase
{
    CONST URL = '/api/logout';

    protected $user;

    public function setUp() : void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'test@user.com',
        ]);
    }

    public function testlogout()
    {
        $this->actingAs($this->user);
        
        $this->assertFalse(Auth::guest());

        $this->postJson(self::URL, [])
            ->assertStatus(200);

        $this->assertTrue(Auth::guest());
    }
}
