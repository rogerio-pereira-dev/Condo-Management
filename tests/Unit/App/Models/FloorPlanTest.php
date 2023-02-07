<?php

namespace Tests\Unit\App\Models;

use App\Models\FloorPlan;
use Illuminate\Database\Eloquent\Model;
use Tests\Unit\App\Models\ModelsTestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FloorPlanTest extends ModelsTestCase
{
    protected function model() : Model
    {
        return new FloorPlan();
    }

    protected function expectedTraits() : array
    {
        return [
            HasFactory::class,
            SoftDeletes::class,
        ];
    }

    protected function expectedFillable() : array
    {
        return [
            'name',
            'bedrooms',
            'en_suite',
            'has_garage',
            'price',
        ];
    }

    protected function expectedHidden() : array
    {
        return [];
    }

    protected function expectedCasts() : array
    {
        return [
            'id' => 'int',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
