<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\MedicineTransactionController;
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
        Route::resource('appointments', AppointmentController::class);

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

        // مسارات السجلات الطبية للمريض
        Route::get('/patients/{patient}/medical-history', [MedicalRecordController::class, 'history'])
            ->name('patients.medical-history');

        Route::get('/patients/{patient}/medical-history/pdf', [MedicalRecordController::class, 'historyPdf'])
            ->name('patients.medical-history.pdf');

        Route::resource('rooms', RoomController::class);
        Route::resource('medical-records', MedicalRecordController::class);

        // الوصفات الطبية
        Route::resource('prescriptions', PrescriptionController::class);
        Route::get('/prescriptions/{prescription}/print', [PrescriptionController::class, 'print'])
            ->name('prescriptions.print');

        // عناصر الوصفات الطبية - مسارات احترافية
        Route::resource('prescription-items', PrescriptionItemController::class);

        // تصدير PDF
        Route::get('/prescriptions/{prescription}/items/pdf', [PrescriptionItemController::class, 'exportPdf'])
            ->name('prescriptions.items.pdf');

        Route::get('/patients/{patient}/prescriptions/pdf', [PrescriptionItemController::class, 'exportAllPrescriptionsPdf'])
            ->name('patients.prescriptions.pdf');

        // API-like routes for AJAX
        Route::get('/prescriptions/{prescription}/items', [PrescriptionItemController::class, 'getByPrescription'])
            ->name('api.prescriptions.items');

        Route::get('/prescription-items/{prescriptionItem}/details', [PrescriptionItemController::class, 'getDetails'])
            ->name('api.prescription-items.details');

        Route::post('/prescription-items/check-medication', [PrescriptionItemController::class, 'checkMedication'])
            ->name('api.prescription-items.check');

        Route::resource('medications', MedicationController::class);

        // Medicine Transactions
        Route::resource('medicine-transactions', MedicineTransactionController::class);

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
    // appointments route moved to Admin|Supervisor group to avoid duplicate
});

require __DIR__.'/auth.php';
