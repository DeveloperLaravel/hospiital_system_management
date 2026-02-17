<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PermissionController;
// use App\Http\Livewire\Appointments;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
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

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==============================
// 🔐 جميع الصفحات المحمية
// ==============================
Route::middleware('auth')->group(function () {
    Route::resource('medical_records', MedicalRecordController::class);

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
    Route::middleware('permission:department-list')->group(function () {
        Route::resource('departments', DepartmentController::class);
    });

    // المرضى
    Route::middleware('permission:patient-list')->group(function () {
        Route::resource('patients', PatientController::class);
    });

    // الأطباء
    Route::middleware('permission:view doctors')->group(function () {
        Route::resource('doctors', DoctorController::class);
    });

    // المواعيد
    Route::middleware('permission:view appointments')->group(function () {
        Route::resource('appointments', AppointmentController::class);
    });

    // ==============================
    // 👑 إدارة النظام (Admin Panel)
    // ==============================

    // المستخدمين
    Route::middleware('permission:manage users')->group(function () {
        Route::resource('users', UserController::class);
    });

    // الأدوار
    Route::middleware('permission:manage roles')->group(function () {
        Route::resource('roles', RoleController::class);
    });

    // الصلاحيات
    Route::middleware('permission:manage permissions')->group(function () {
        Route::resource('permissions', PermissionController::class);
    });

});

require __DIR__.'/auth.php';
