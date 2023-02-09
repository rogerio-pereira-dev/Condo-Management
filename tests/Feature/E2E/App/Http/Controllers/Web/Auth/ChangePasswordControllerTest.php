<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Inertia\Testing\AssertableInertia;

class ChangePassswordControllerTest extends TestCase
{
    public function testRenderResetPasswordPage()
    {
        $user = $this->userAdmin;

        $this->assertGuest()
            ->get('/change-password/'.$user->uuid)
            ->assertInertia(fn (AssertableJson $page) => 
                $page->component('Auth/ResetPassword')
            );
    }

    public function testRenderResetPasswordPageWithWrongUuid()
    {
        $user = $this->userAdmin;

        $this->assertGuest()
            ->get('/change-password/wrong-uuid')
            ->assertInertia(fn (AssertableJson $page) => 
                $page->component('Auth/ResetPassword')
            );
    }

    public function testResetPasswordPageShouldLogoutAndRedirectIfAuthenticated()
    {
        $user = $this->userAdmin;

        $this->actingAs($user)
            ->get('/change-password/'.$user->uuid)
            ->assertRedirect('/change-password/'.$user->uuid);
        $this->assertGuest();
    }


    public function testRenderChangePasswordPage()
    {
        $this->actingAs($this->userAdmin)
            ->get('/change-password')
            ->assertInertia(fn (AssertableJson $page) => 
                $page->component('Auth/ChangePassword')
            );
    }
}
