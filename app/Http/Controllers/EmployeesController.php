<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        return Inertia::render('Employees/Index');
    }
}
