<?php

namespace App\Services\User;

use App\Data\UserData;
use App\Models\User;

class UserStoreService
{

    public function store(UserData $data): User
    {
        return User::create($data->toArray());
    }

    public function update(User $user, UserData $data): User
    {
        $user->update($data->toArray());
        return $user;
    }

    public function destroy(User $user)
    {
        return $user->delete();
    }
}
