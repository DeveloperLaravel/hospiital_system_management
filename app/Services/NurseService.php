<?php

namespace App\Services;

use App\Models\Nurse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NurseService
{
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $query = Nurse::query()
            ->with('department');

        // search بالاسم أو الهاتف
        if (! empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        // filter حسب القسم
        if (! empty($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        return $query
            ->latest()
            ->paginate(10);
    }

    public function store(array $data): Nurse
    {
        return Nurse::create($data);
    }

    public function update(Nurse $nurse, array $data): Nurse
    {
        $nurse->update($data);

        return $nurse;
    }

    public function delete(Nurse $nurse): void
    {
        $nurse->delete();
    }

    public function find(int $id): Nurse
    {
        return Nurse::with('department')
            ->findOrFail($id);
    }
}
