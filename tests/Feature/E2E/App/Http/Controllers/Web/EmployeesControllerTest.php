<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Web;

use Tests\TestCase;
use Inertia\Testing\Assert;
use Inertia\Testing\AssertableInertia;
use Illuminate\Testing\Fluent\AssertableJson;

class EmployeesControllerTest extends TestCase
{
    public function testRenderEmployeesPage()
    {
        $this
            ->actingAs($this->userAdmin)
            ->get('/employees')
            ->assertInertia(fn (Assert $page) => 
                $page->component('Employees/Index')
            );
    }
}
