<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web;

use Tests\TestWebCase;
use Inertia\Testing\AssertableInertia;

class EmployeesControllerTest extends TestWebCase
{
    public function testRenderEmployeesPage()
    {
        $this
            ->actingAs($this->userAdmin)
            ->get('/employees')
            ->assertInertia(fn (AssertableInertia $page) => 
                $page->component('Employees/Index')
            );
    }
}
