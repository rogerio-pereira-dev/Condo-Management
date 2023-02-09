<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web;

use Tests\TestCase;
use Inertia\Testing\AssertableInertia;
use Illuminate\Testing\Fluent\AssertableJson;

class HomeControllerTest extends TestCase
{
    public function testRenderHomePageIfAuthenticated()
    {
        $this->actingAs($this->userAdmin)
            ->get('/')
            ->assertInertia(fn (AssertableJson $page) => 
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
