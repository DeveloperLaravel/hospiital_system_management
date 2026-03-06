<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\MedicineTransactionController;
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
        // مسارات الأقسام - Department Routes (Livewire)
        Route::get('departments', \App\Livewire\DepartmentManager::class)->name('departments.index');

        // مسارات الأطباء - Doctors Routes (Livewire)
        Route::get('doctors', \App\Livewire\DoctorManager::class)->name('doctors.index');

        // API Routes للأقسام
        Route::get('api/departments', function () {
            return response()->json(\App\Models\Department::all(['id', 'name', 'salary']));
        })->name('api.departments.index');

        // مسارات المواعيد - Appointments Routes (Livewire)
        Route::get('appointments', \App\Livewire\AppointmentManager::class)->name('appointments.index');
        // مسارات المرضى - Patients Routes (Livewire)
        Route::get('patients', \App\Livewire\PatientManager::class)->name('patients.index');

        // ملاحظة: باقي مسارات patients (payment, charge, search, medical-history) تبقى في PatientController

        // مسارات الدفع والرسوم للمرضى
        // Route::post('/patients/{patient}/payment', [PatientController::class, 'addPayment'])
        //     ->name('patients.payment');

        // Route::post('/patients/{patient}/charge', [PatientController::class, 'addCharge'])
        //     ->name('patients.charge');

        // // البحث السريع (AJAX)
        // Route::get('/patients/search', [PatientController::class, 'search'])
        //     ->name('patients.search');

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

        // ========================================
        // الفواتير - Invoice Routes
        // ========================================
        Route::resource('invoices', InvoiceController::class);

        // إجراءات الفاتورة - Invoice Actions
        Route::post('/invoices/{invoice}/mark-as-paid', [InvoiceController::class, 'markAsPaid'])
            ->name('invoices.markAsPaid');

        Route::post('/invoices/{invoice}/mark-as-unpaid', [InvoiceController::class, 'markAsUnpaid'])
            ->name('invoices.markAsUnpaid');

        Route::get('/invoices/{invoice}/export-pdf', [InvoiceController::class, 'exportPdf'])
            ->name('invoices.exportPdf');

        // ========================================
        // عناصر الفاتورة - Invoice Items Routes (متداخلة)
        // ========================================
        Route::controller(InvoiceItemController::class)->group(function () {
            // عرض عناصر الفاتورة
            Route::get('/invoices/{invoice}/items', 'index')
                ->name('invoices.items.index');

            // نموذج إضافة عنصر جديد
            Route::get('/invoices/{invoice}/items/create', 'create')
                ->name('invoices.items.create');

            // حفظ العنصر الجديد
            Route::post('/invoices/{invoice}/items', 'store')
                ->name('invoices.items.store');

            // عرض عنصر محدد
            Route::get('/invoices/{invoice}/items/{item}', 'show')
                ->name('invoices.items.show');

            // نموذج تعديل العنصر
            Route::get('/invoices/{invoice}/items/{item}/edit', 'edit')
                ->name('invoices.items.edit');

            // تحديث العنصر
            Route::put('/invoices/{invoice}/items/{item}', 'update')
                ->name('invoices.items.update');

            // حذف العنصر
            Route::delete('/invoices/{invoice}/items/{item}', 'destroy')
                ->name('invoices.items.destroy');

            // AJAX: Get items as JSON
            Route::get('/invoices/{invoice}/items/json', 'getItems')
                ->name('invoices.items.json');
        });

        // ========================================
        // API Routes للفواتير
        // ========================================
        Route::get('/api/invoices/unpaid', [InvoiceController::class, 'getUnpaid'])
            ->name('api.invoices.unpaid');

        Route::get('/api/invoices/overdue', [InvoiceController::class, 'getOverdue'])
            ->name('api.invoices.overdue');

        Route::get('/api/invoices/statistics', [InvoiceController::class, 'getStatistics'])
            ->name('api.invoices.statistics');

        // API: Get invoice items as JSON
        Route::get('/api/invoices/{invoice}/items', [InvoiceItemController::class, 'getItems'])
            ->name('api.invoices.items');

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
