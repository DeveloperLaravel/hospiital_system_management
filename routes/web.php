<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\InvoiceController;
// use App\Http\Livewire\Appointments;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\MedicineTransactionController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\PrescriptionItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StockAlertController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});
Route::get('dashboard', DashboardController::class, 'index')->middleware(['auth', 'verified'])->name('dashboard');

// ==============================
// 🔐 جميع الصفحات المحمية
// ==============================
Route::middleware('auth')->group(function () {

    // ==============================
    // 👤 Profile
    // ==============================
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // ==============================
    // 🏥 إدارة المستشفى
    // ==============================

    // الأقسام
    Route::middleware('permission:department-list')->group(function () {});

    // المرضى
    Route::middleware('permission:patients.list')->group(function () {});

    // الأطباء
    Route::middleware('permission:doctors-view')->group(function () {});

    // المواعيد

    // ==============================
    // 👑 إدارة النظام (Admin Panel)
    // ==============================

    // المستخدمين
    Route::middleware('permission:manage users')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('appointments', AppointmentController::class);
        Route::resource('doctors', DoctorController::class);
        Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');
        Route::resource('patients', PatientController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('medical-records', MedicalRecordController::class);
        Route::resource('medications', MedicationController::class)
            ->except(['create', 'edit', 'show']);
        Route::get('/medications/scan/{qr}', [MedicationController::class, 'scan'])
            ->name('medications.qr');
        Route::post('/medicines/scan', [MedicationController::class, 'scanApi']);
        Route::resource('prescriptions', PrescriptionController::class);
        Route::resource('prescription-items', PrescriptionItemController::class);
        Route::get(
            'patients/{patient}/prescriptions/pdf',
            [PrescriptionItemController::class, 'exportAllPrescriptionsPdf']
        )->name('patients.prescriptions.pdf');
        Route::get(
            'prescriptions/{prescription}/pdf',
            [PrescriptionItemController::class, 'exportPdf']
        )->name('prescriptions.pdf');
        Route::get('patients/{patient}', [PatientController::class, 'show']); // بيانات المريض للـ modal
        Route::get('medications/{medication}', [MedicationController::class, 'show']); // بيانات الدواء إذا أردنا
        // ->middleware('permission:prescriptions manage')
        // ->middleware('permission:invoices.manage')
        Route::resource('invoices.items', InvoiceItemController::class);
        Route::patch('invoices/{invoice}/mark-paid', [InvoiceController::class, 'markPaid'])
            ->name('invoices.markPaid');
        Route::resource('rooms', RoomController::class);
        Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])
            ->name('invoices.print');
        Route::resource('nurses', NurseController::class);
    });
    Route::get(
        'patients/{patient}/history',
        [MedicalRecordController::class, 'history']
    )->name('patients.history');
    Route::get(
        'patients/{patient}/history/pdf',
        [MedicalRecordController::class, 'historyPdf']
    )->name('patients.history.pdf');
    Route::post('/rooms/{room}/admit', [RoomController::class, 'admit'])
        ->name('rooms.admit');

    Route::post('/rooms/{room}/discharge', [RoomController::class, 'discharge'])
        ->name('rooms.discharge');
});
Route::resource('medicine-transactions', MedicineTransactionController::class);
Route::get('stock-alerts', [StockAlertController::class, 'index'])->name('stock-alerts.index');
Route::post('stock-alerts/{stockAlert}/mark-read', [StockAlertController::class, 'markRead'])->name('stock-alerts.markRead');
Route::delete('stock-alerts/{stockAlert}', [StockAlertController::class, 'destroy'])->name('stock-alerts.destroy');
Route::resource('invoices', InvoiceController::class);
require __DIR__.'/auth.php';
