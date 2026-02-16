<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PermissionController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['auth', 'permission:role-list']], function () {});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::resource('users', UserController::class)->middleware(['auth', 'verified']);
Route::resource('roles', RoleController::class)->middleware(['auth', 'verified']);
Route::resource('permissions', PermissionController::class)->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('departments', DepartmentController::class);
    Route::resource('doctors', DoctorController::class);

});
Route::group(['middleware' => ['permission:department-list']], function () {
    // Route::get('/departments', [DepartmentController::class, 'index']);
});
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {});
require __DIR__.'/auth.php';
