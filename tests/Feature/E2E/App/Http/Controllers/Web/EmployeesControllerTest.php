<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web;

use Tests\TestCase;
use Inertia\Testing\AssertableInertia;

class EmployeesControllerTest extends TestCase
{
    public function testRenderEmployeesPage()
    {
        $this
            ->actingAs($this->userAdmin)
            ->get('/employees')
            ->assertSuccessful()
            ->assertInertia(fn (AssertableInertia $page) => 
                $page->component('Employees/Index')
            );
    }
}
