<?php

namespace App\Services;

use App\Models\Appointment;

class AppointmentService
{
    public function getAll($search = null, $perPage = 5)
    {
        return Appointment::with(['patient', 'doctor'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('patient', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        return Appointment::create($data);
    }

    public function update(Appointment $appointment, array $data)
    {
        return $appointment->update($data);
    }

    public function delete(Appointment $appointment)
    {
        return $appointment->delete();
    }
}
