<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web\Auth;

use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    public function testRenderLoginPageAfterLogout()
    {
        $this->actingAs($this->userAdmin)
            ->get('/logout')
            ->assertRedirect('/login');
    }
}
