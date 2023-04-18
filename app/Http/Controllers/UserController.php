<?php

namespace App\Http\Controllers;

use App\Data\UserCreateData;
use App\Data\UserSearchData;
use App\Data\UserUpdateData;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\UserListService;
use App\Services\User\UserStoreService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function index(UserListService $service, Request $request)
    {
        return UserResource::collection($service->pagination(
            $request->get('page', 1),
            $request->get('perPage', 10)
        ));
    }

    public function search(UserListService $service, UserSearchData $data)
    {
        return UserResource::collection($service->search($data->search));
    }

    public function store(UserCreateData $data, UserStoreService $service): UserResource
    {
        return new UserResource($service->store($data));
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(User $user, UserUpdateData $data, UserStoreService $service): UserResource
    {
        return new UserResource($service->update($user, $data));
    }

    public function destroy(User $user, UserStoreService $service)
    {
        if (auth()->user()->id === $user->id) {
            return response()->json([
                'message' => 'Cannot delete your own account',
            ], 422);
        }
        return ['deleted' => $service->destroy($user)];
    }
}
