<?php

namespace App\Services;

use App\Models\Doctor;

class DoctorService
{
    public function getAll()
    {
        return Doctor::with('department')->get();
    }

    public function find($id)
    {
        return Doctor::find($id);
    }

    public function store(array $data)
    {
        return Doctor::create($data);
    }

    public function update(Doctor $doctor, array $data)
    {
        return $doctor->update($data);
    }

    public function delete(Doctor $doctor)
    {
        return $doctor->delete();
    }
}
