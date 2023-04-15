<?php

namespace App\Services\User;

use App\Models\User;

class UserListService
{
    public function list(int $page)
    {
        return User::query()->orderBy('created_at', 'desc')->paginate(page: $page);
    }
}
