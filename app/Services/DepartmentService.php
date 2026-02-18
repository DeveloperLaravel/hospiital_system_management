<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DepartmentService
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Department::latest()->paginate($perPage);
    }

    public function store(array $data): Department
    {
        return Department::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(Department $department, array $data): bool
    {
        return $department->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function delete(Department $department): bool
    {
        return $department->delete();
    }
}
