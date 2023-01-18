<?php

namespace Tests\Unit\App\Http\Resources;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class ResourceTestCase extends TestCase
{
    abstract protected function model() : Model;

    abstract protected function resource(Model $model) : JsonResource;

    abstract protected function expectedJsonStructure() : array;

    protected function createModel()
    {
        return $this->model()->factory()->create();
    }

    public function test_resouce_structure()
    {
        $model          = $this->model();
        $data           = $this->createModel();
        $resource       = $this->resource($model)->toArray($data);
        $resourceKeys   = array_keys($resource);

        $expectedStructure  = $this->expectedJsonStructure();

        $this->assertEquals($expectedStructure, $resourceKeys);
    }
}
