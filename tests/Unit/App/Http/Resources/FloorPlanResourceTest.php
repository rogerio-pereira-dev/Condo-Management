<?php

namespace Tests\Unit\App\Http\Resources;

use App\Models\FloorPlan;
use App\Http\Resources\FloorPlanResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class FloorPlanResourceTest extends ResourceTestCase
{
    protected function model() : Model
    {
        return new FloorPlan;
    }

    protected function resource(Model $model) : JsonResource
    {
        $model = $this->model();

        return new FloorPlanResource($model);
    }

    protected function expectedJsonStructure() : array
    {
        return [
            'name',
            'bedrooms',
            'en_suite',
            'has_garage',
            'price',
        ];
    }
}
