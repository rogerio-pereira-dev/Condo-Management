<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web\Auth;

use Tests\TestCase;
use App\Models\User;
use Inertia\Testing\Assert;
use Inertia\Testing\AssertableInertia;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
