<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

class LogoutControllerTest extends TestCase
{
    CONST URL = '/logout';

    public function testRenderLoginPageAfterLogout()
    {
        $this->actingAs($this->userAdmin)
            ->get(self::URL)
            ->assertRedirect('/login');
    }
}
