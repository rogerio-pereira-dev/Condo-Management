<?php

namespace Tests\Unit\App\Observers;

use App\Models\User;
use Tests\TestCase;

class UserObserverTest extends TestCase
{
    public function test_observer_creating()
    {
        $data = [
            'name' => 'User UUID',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            'role' => 'Admin'
        ];

        $user = User::create($data);

        $this->assertNotNull($user->uuid);
    }
}
