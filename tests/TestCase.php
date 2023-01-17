<?php

namespace Tests;

use App\Models\User;
use Tests\MigrateFreshSeedOnce;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, MigrateFreshSeedOnce;

    /*
     * MigrateFreshSeedOnce has a static variable $user.
     *      To access it use
     *      self::$user;
     */
}
