<?php

namespace App\Services\User;

use App\Models\User;

class UserListService
{
    public function pagination(int $page, int $perPage)
    {
        return User::with('department')
            ->orderBy('created_at', 'desc')
            ->paginate(page: $page, perPage: $perPage);
    }
}
