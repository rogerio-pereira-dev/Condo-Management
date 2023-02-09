<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web\Auth;

use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class LoginControllerTest extends TestCase
{
    public function testRenderLoginPage()
    {
        $this->assertGuest()
            ->get('/login')
            ->assertInertia(fn (Assert $page) => 
                $page->component('Auth/Login')
            );
    }

    public function testAuthUserCantAccessLoginPage()
    {
        $this->actingAs($this->userAdmin)
            ->get('/login')
            ->assertRedirect('/');
    }
}
