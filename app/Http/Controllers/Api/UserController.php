<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return UserResource::collection($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return new UserResource($user);
    }

    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->all());

        return new UserResource($user);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->all());

        return new UserResource($user);
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
    }
}
