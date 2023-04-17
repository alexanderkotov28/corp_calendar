<?php

namespace App\Http\Controllers;

use App\Data\DepartmentData;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Services\Department\DepartmentListService;
use App\Services\Department\DepartmentStoreService;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Department::class);
    }

    public function index(DepartmentListService $service)
    {
        return DepartmentResource::collection($service->list());
    }

    public function store(DepartmentStoreService $service, DepartmentData $data)
    {
        return new DepartmentResource($service->store($data));
    }

    public function show(Department $department)
    {
        return new DepartmentResource($department);
    }

    public function update(DepartmentStoreService $service, DepartmentData $data, Department $department)
    {
        return new DepartmentResource($service->update($department, $data));
    }

    public function destroy(Department $department, DepartmentStoreService $service)
    {
        if ($department->users()->exists()) {
            return response()->json([
                'message' => 'Cannot delete department having stuff. Transfer staff first',
            ], 422);
        }
        return $service->destroy($department);
    }
}
