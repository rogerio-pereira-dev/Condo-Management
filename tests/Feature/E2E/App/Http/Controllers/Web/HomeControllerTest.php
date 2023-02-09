<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web;

use Tests\TestCase;
use Inertia\Testing\AssertableInertia;

class HomeControllerTest extends TestCase
{
    public function testRenderHomePageIfAuthenticated()
    {
        $this->actingAs($this->userAdmin)
            ->get('/')
            ->assertInertia(fn (AssertableInertia $page) => 
                $page->component('Dashboard/Dashboard')
            );
    }
    
    public function testRenderLoginPageIfGuest()
    {
        $this->assertGuest()
            ->get('/')
            ->assertRedirect('/login');
    }
}
