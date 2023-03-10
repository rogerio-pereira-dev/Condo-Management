<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $category = null)
    {
        $query = User::orderBy('id');

        if(isset($category) && $category == 'Employee') {
            $query->where('role', '<>', 'Tenant');
        }
        elseif(isset($category)) {
            $query->where('role', $category);
        }

        $users = $query->get();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $user->refresh();   //Required because if role has a default value it will return null
        
        return response()->json([
                        'message' => 'User created.',
                        'user' => new UserResource($user),
                    ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
        
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->validated();
        unset($data['role']);
        unset($data['password']);

        $user = User::where('id', $id)
                    ->firstOrFail();

        $user->update($data);

        return response()->json([
            'message' => 'User updated.',
            'user' => new UserResource($user),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)
                    ->firstOrfail();
        $user->delete();

        return response()->json([], 204);
    }
}
