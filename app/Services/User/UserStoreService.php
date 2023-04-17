<?php

namespace App\Services\User;

use App\Data\UserCreateData;
use App\Data\UserUpdateData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserStoreService
{

    public function store(UserCreateData $data): User
    {
        $data->password = Hash::make($data->password);
        return User::create($data->toArray());
    }

    public function update(User $user, UserUpdateData $data): User
    {
        $data = $data->toArray();
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function destroy(User $user)
    {
        return $user->delete();
    }
}
