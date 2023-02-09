<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

class LogoutControllerTest extends TestCase
{
    public function testRenderLoginPageAfterLogout()
    {
        $this->actingAs($this->userAdmin)
            ->get('/logout')
            ->assertSuccessful()
            ->assertRedirect('/login');
    }
}
