<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    /**
     * Get all appointments with optional search
     */
    public function getAllAppointments($search = null, $perPage = 10): LengthAwarePaginator
    {
        return Appointment::with(['patient', 'doctor'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('patient', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })->orWhereHas('doctor', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get appointments for today
     */
    public function getTodayAppointments()
    {
        return Appointment::with(['patient', 'doctor'])
            ->today()
            ->orderBy('time')
            ->get();
    }

    /**
     * Get upcoming appointments
     */
    public function getUpcomingAppointments($limit = 10)
    {
        return Appointment::with(['patient', 'doctor'])
            ->where('date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('date')
            ->orderBy('time')
            ->limit($limit)
            ->get();
    }

    /**
     * Get appointments by doctor
     */
    public function getByDoctor($doctorId, $date = null)
    {
        return Appointment::with(['patient', 'doctor'])
            ->byDoctor($doctorId)
            ->when($date, function ($query) use ($date) {
                $query->byDate($date);
            })
            ->orderBy('date')
            ->orderBy('time')
            ->get();
    }

    /**
     * Get appointments by patient
     */
    public function getByPatient($patientId)
    {
        return Appointment::with(['doctor'])
            ->byPatient($patientId)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();
    }

    /**
     * Check for appointment conflicts
     */
    public function hasConflict($doctorId, $date, $time, $excludeId = null): bool
    {
        return Appointment::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->where('time', $time)
            ->when($excludeId, function ($query) use ($excludeId) {
                $query->where('id', '!=', $excludeId);
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
    }

    /**
     * Check for patient appointment conflict
     */
    public function hasPatientConflict($patientId, $date, $time, $excludeId = null): bool
    {
        return Appointment::where('patient_id', $patientId)
            ->where('date', $date)
            ->where('time', $time)
            ->when($excludeId, function ($query) use ($excludeId) {
                $query->where('id', '!=', $excludeId);
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
    }

    /**
     * Create a new appointment
     */
    public function create(array $data): Appointment
    {
        return DB::transaction(function () use ($data) {
            return Appointment::create($data);
        });
    }

    /**
     * Update an appointment
     */
    public function update(Appointment $appointment, array $data): bool
    {
        return DB::transaction(function () use ($appointment, $data) {
            return $appointment->update($data);
        });
    }

    /**
     * Delete an appointment
     */
    public function delete(Appointment $appointment): bool
    {
        return DB::transaction(function () use ($appointment) {
            return $appointment->delete();
        });
    }

    /**
     * Confirm an appointment
     */
    public function confirm(Appointment $appointment): bool
    {
        return $appointment->update(['status' => 'confirmed']);
    }

    /**
     * Complete an appointment
     */
    public function complete(Appointment $appointment): bool
    {
        return $appointment->update(['status' => 'completed']);
    }

    /**
     * Cancel an appointment
     */
    public function cancel(Appointment $appointment): bool
    {
        return $appointment->update(['status' => 'cancelled']);
    }

    /**
     * Get available patients (patients without today's appointment)
     */
    public function getAvailablePatients()
    {
        $todayAppointmentPatientIds = Appointment::today()
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('patient_id')
            ->toArray();

        return Patient::whereNotIn('id', $todayAppointmentPatientIds)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Get all doctors
     */
    public function getAllDoctors()
    {
        return Doctor::orderBy('name', 'asc')->get();
    }

    /**
     * Get appointment statistics
     */
    public function getStatistics(): array
    {
        return [
            'total' => Appointment::count(),
            'pending' => Appointment::pending()->count(),
            'confirmed' => Appointment::confirmed()->count(),
            'completed' => Appointment::completed()->count(),
            'cancelled' => Appointment::cancelled()->count(),
            'today' => Appointment::today()->count(),
        ];
    }
}
