<?php

namespace App\Http\Controllers;

use App\Data\UserData;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\UserListService;
use App\Services\User\UserStoreService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UserListService $service, Request $request)
    {
        return UserResource::collection($service->list($request->get('page', 1)));
    }

    public function store(UserData $data, UserStoreService $service): UserResource
    {
        return new UserResource($service->store($data));
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(User $user, UserData $data, UserStoreService $service): UserResource
    {
        return new UserResource($service->update($user, $data));
    }

    public function destroy(User $user, UserStoreService $service)
    {
        return [
            'deleted' => $service->destroy($user),
        ];
    }
}
