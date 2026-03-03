<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\PrescriptionItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin فقط
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });

    /*
     |--------------------------------------------------------------------------
     | Admin + Supervisor
     |--------------------------------------------------------------------------
     */
    Route::middleware(['role:Admin|Supervisor'])->group(function () {

        Route::resource('departments', DepartmentController::class);
        Route::resource('doctors', DoctorController::class);

        // مسارات المرضى
        Route::resource('patients', PatientController::class);

        // مسارات الدفع والرسوم للمرضى
        Route::post('/patients/{patient}/payment', [PatientController::class, 'addPayment'])
            ->name('patients.payment');

        Route::post('/patients/{patient}/charge', [PatientController::class, 'addCharge'])
            ->name('patients.charge');

        // البحث السريع (AJAX)
        Route::get('/patients/search', [PatientController::class, 'search'])
            ->name('patients.search');

        Route::resource('rooms', RoomController::class);
        Route::resource('appointments', AppointmentController::class);
        Route::resource('medical-records', MedicalRecordController::class);
        Route::resource('prescriptions', PrescriptionController::class);
        Route::resource('prescription-items', PrescriptionItemController::class);
        Route::resource('medications', MedicationController::class);
        Route::post('/rooms/{room}/admit', [RoomController::class, 'admit'])
            ->name('rooms.admit');

        Route::post('/rooms/{room}/discharge', [RoomController::class, 'discharge'])
            ->name('rooms.discharge');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin + Receptionist
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Admin|Receptionist'])->group(function () {

        Route::post('/rooms/{room}/admit', [RoomController::class, 'admit'])
            ->name('rooms.admit');

        Route::post('/rooms/{room}/discharge', [RoomController::class, 'discharge'])
            ->name('rooms.discharge');
    });

    /*
     |--------------------------------------------------------------------------
     | Admin + Doctor
     |--------------------------------------------------------------------------
     */
    Route::middleware(['role:Admin|Doctor'])->group(function () {
        Route::resource('appointments', AppointmentController::class);
    });

});

require __DIR__.'/auth.php';
