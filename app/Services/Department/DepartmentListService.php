<?php

namespace App\Services\Department;

use App\Models\Department;

class DepartmentListService
{
    public function list()
    {
        return Department::all();
    }
}
