<?php

namespace App\Services\Department;

use App\Data\DepartmentData;
use App\Models\Department;

class DepartmentStoreService
{
    public function store(DepartmentData $data): Department
    {
        return Department::create($data->toArray());
    }

    public function update(Department $department, DepartmentData $data): Department
    {
        $department->update($data->toArray());
        return $department;
    }

    public function destroy(Department $department)
    {
        return $department->delete();
    }
}
