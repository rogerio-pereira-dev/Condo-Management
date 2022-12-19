<?php

namespace Tests\Unit\App\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tests\Unit\App\Models\ModelsTestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTest extends ModelsTestCase
{
    protected function model() : Model
    {
        return new User();
    }

    protected function expectedTraits() : array
    {
        return [
            HasApiTokens::class,
            HasFactory::class,
            Notifiable::class,
            SoftDeletes::class,
        ];
    }

    protected function expectedFillable() : array
    {
        return [
            'name',
            'email',
            'password',
        ];
    }

    protected function expectedHidden() : array
    {
        return [
            'password',
            'remember_token',
        ];
    }

    protected function expectedCasts() : array
    {
        return [
            'id' => 'int',
            'email_verified_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
