<?php

namespace Tests;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

trait MigrateFreshSeedOnce
{
    /**
    * If true, setup has run at least once.
    * @var boolean
    */
    protected static $setUpHasRunOnce = false;
    protected static $user;

    /**
    * After the first run of setUp "migrate:fresh --seed"
    * @return void
    */
    public function setUp() : void
    {
        parent::setUp();

        if (!static::$setUpHasRunOnce) {
            Artisan::call('migrate:fresh');
            // Artisan::call(
            //     'db:seed', ['--class' => 'DatabaseSeeder']
            // );

            static::$user = User::factory()->create([
                                'email' => 'test@user.com',
                            ]);
            $this->assertDatabaseHas('users', [
                'id' => 1,
                'email' => 'test@user.com',
            ]);
            
            static::$setUpHasRunOnce = true;
         }
    }
}