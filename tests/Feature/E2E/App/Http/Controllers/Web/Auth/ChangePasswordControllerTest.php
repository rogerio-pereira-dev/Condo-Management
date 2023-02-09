<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web\Auth;

use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class ChangePassswordControllerTest extends TestCase
{
    public function testRenderResetPasswordPage()
    {
        $user = $this->userAdmin;

        $this->assertGuest()
            ->get('/change-password/'.$user->uuid)
            ->assertInertia(fn (Assert $page) => 
                $page->component('Auth/ResetPassword')
            );
    }

    public function testRenderResetPasswordPageWithWrongUuid()
    {
        $user = $this->userAdmin;

        $this->assertGuest()
            ->get('/change-password/wrong-uuid')
            ->assertInertia(fn (Assert $page) => 
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
            ->assertInertia(fn (Assert $page) => 
                $page->component('Auth/ChangePassword')
            );
    }
}
