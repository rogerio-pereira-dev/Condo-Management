<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web\Auth;

use Tests\TestWebCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

class LogoutControllerTest extends TestWebCase
{
    public function testRenderLoginPageAfterLogout()
    {
        $this->actingAs($this->userAdmin)
            ->get('/logout')
            ->assertRedirect('/login');
    }
}
