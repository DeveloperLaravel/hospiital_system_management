<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\DashboardManager;
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
    // Dashboard (Livewire)
    Route::get('dashboard', DashboardManager::class)->name('dashboard');

    // Profile Routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Admin'])->group(function () {
        // Users (Livewire)
        Route::get('users', \App\Livewire\UserManager::class)->name('users.index');
        // Roles (Livewire)
        Route::get('roles', \App\Livewire\RoleManager::class)->name('roles.index');
        // Permissions (Livewire)
        Route::get('permissions', \App\Livewire\PermissionManager::class)->name('permissions.index');

    });

    /*
    |--------------------------------------------------------------------------
    | Admin + Supervisor Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Admin|Supervisor'])->group(function () {

        // ========================================
        // Livewire Components
        // ========================================

        // Departments
        Route::get('departments', \App\Livewire\DepartmentManager::class)->name('departments.index');

        // Doctors
        Route::get('doctors', \App\Livewire\DoctorManager::class)->name('doctors.index');

        // Patients
        Route::get('patients', \App\Livewire\PatientManager::class)->name('patients.index');

        // Appointments
        Route::get('appointments', \App\Livewire\AppointmentManager::class)->name('appointments.index');

        // Rooms
        Route::get('rooms', \App\Livewire\RoomManager::class)->name('rooms.index');

        // Prescriptions
        Route::get('prescriptions', \App\Livewire\PrescriptionManager::class)->name('prescriptions.index');

        // Prescription Items
        Route::get('prescription-items', \App\Livewire\PrescriptionItemManager::class)->name('prescription-items.index');

        // Medications
        Route::get('medications', \App\Livewire\MedicationManager::class)->name('medications.index');

        // Medicine Transactions
        Route::get('medicine-transactions', \App\Livewire\MedicineTransactionManager::class)->name('medicine-transactions.index');

        // Medical Records
        Route::get('medical-records', \App\Livewire\MedicalRecordManager::class)->name('medical-records.index');

        // Stock Alerts
        Route::get('stock-alerts', \App\Livewire\StockAlertManager::class)->name('stock-alerts.index');

        // ========================================
        // API Routes
        // ========================================

        // Departments API
        Route::get('api/departments', function () {
            return response()->json(\App\Models\Department::all(['id', 'name', 'salary']));
        })->name('api.departments.index');

        // ========================================
        // Patient Medical History
        // ========================================

        // ========================================
        // Room Actions
        // ========================================

        // ========================================
        // Medicine Transactions
        // ========================================

        // ========================================
        // Invoice Routes (Livewire)
        // ========================================
        Route::get('invoices', \App\Livewire\InvoiceManager::class)->name('invoices.index');

        // Invoice Items Routes (Livewire)
        Route::get('invoice-items', \App\Livewire\InvoiceItemManager::class)->name('invoice-items.index');

        // ========================================
        // Invoice API Routes (kept for compatibility)
        // ========================================

    });

    /*
    |--------------------------------------------------------------------------
    | Admin + Receptionist Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Admin|Receptionist'])->group(function () {});
});

require __DIR__.'/auth.php';
