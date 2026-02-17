<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $patientsCount = Patient::count();
        $doctorsCount = Doctor::count();
        $appointmentsCount = Appointment::count();
        // $billsCount = Bill::count();

        return view('dashboard', compact(
            'patientsCount',
            'doctorsCount',
            'appointmentsCount',
            // 'billsCount'
        ));
    }
}
