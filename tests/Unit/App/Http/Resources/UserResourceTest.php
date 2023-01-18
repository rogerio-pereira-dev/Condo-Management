<?php

namespace Tests\Unit\App\Http\Resources;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResourceTest extends ResourceTestCase
{
    protected function model() : Model
    {
        return new User;
    }

    protected function resource(Model $model) : JsonResource
    {
        $model = $this->model();

        return new UserResource($model);
    }

    protected function expectedJsonStructure() : array
    {
        return [
            'id',
            'uuid',
            'name',
            'email',
            'role',
        ];
    }
}
