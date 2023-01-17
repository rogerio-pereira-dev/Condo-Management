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

    public function testlogout()
    {
        $this->actingAs($this->userAdmin);
        
        $this->assertFalse(Auth::guest());

        $this->postJson(self::URL, [])
            ->assertStatus(200);

        $this->assertTrue(Auth::guest());
    }
}
