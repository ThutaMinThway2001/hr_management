<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceQrscanController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WebAuthnRegisterController;
use App\Http\Controllers\Auth\WebAuthnLoginController;
use App\Http\Controllers\CheckinCheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('webauthn/register/options', [WebAuthnRegisterController::class, 'options'])
     ->name('webauthn.register.options');
Route::post('webauthn/register', [WebAuthnRegisterController::class, 'register'])
     ->name('webauthn.register');

Route::post('webauthn/login/options', [WebAuthnLoginController::class, 'options'])
     ->name('webauthn.login.options');
Route::post('webauthn/login', [WebAuthnLoginController::class, 'login'])
     ->name('webauthn.login');

Route::get('checkin-checkout', [CheckinCheckoutController::class, 'checkInCheckOut']);
Route::post('checkin-checkout/store',[CheckinCheckoutController::class, 'checkInCheckOutStore']);

Route::middleware('auth')->group(function(){
    Route::get('/dashboard', [PageController::class, 'index']);

    Route::resource('employee', EmployeeController::class);
    Route::get('employee/datatable/ssd', [EmployeeController::class, 'ssd']);

    Route::resource('departments', DepartmentController::class);
    Route::get('department/datatable/ssd', [DepartmentController::class, 'ssd']);

    Route::resource('roles', RoleController::class);
    Route::get('roles/datatable/ssd', [RoleController::class, 'ssd']);
    
    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/datatable/ssd', [PermissionController::class, 'ssd']);

    Route::resource('attendances', AttendanceController::class);
    Route::get('attendances/datatable/ssd', [AttendanceController::class, 'ssd']);

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.profile');
    
    Route::get('attendance/qrscan', [AttendanceQrscanController::class, 'index'])->name('attendanceQrScan');
    Route::post('attendance/qrscan/store', [AttendanceQrscanController::class, 'store'])->name('attendanceQrScanStore');
    Route::get('attendance-overview', [AttendanceController::class, 'overview'])->name('attendance.overview');
    Route::get('attendance-overview-table', [AttendanceController::class, 'overviewTable'])->name('attendance.overview-table');

    Route::resource('company-settings', CompanySettingController::class)->only(['edit','update','show']);
});

require __DIR__.'/auth.php';
