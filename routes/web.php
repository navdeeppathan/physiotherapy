<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\AppointmentFeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientPlanController;
use App\Http\Controllers\PatientPlanSubscriptionController;
use App\Http\Controllers\SpecializationController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\AppointmentTransferRequestController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientAppointmentController;
use App\Http\Controllers\UserAddressController;

Route::get('/doctor/{id}', [DoctorController::class, 'show'])->name('doctor.profile');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search-doctors', [HomeController::class, 'searchDoctors'])->name('search.doctors');
Route::get('/doctor/{id}', [HomeController::class, 'doctorProfile'])->name('doctor.profile');
Route::get('/search', [HomeController::class, 'index'])->name('search');

Route::get('/patient-dashboard', [PatientController::class, 'index'])->name('patient.dashboard');
Route::get('/patient-profile', [PatientController::class, 'profile'])->name('patient.profile');
Route::post('/patient/profile/update', [PatientController::class, 'updateProfile'])->name('patient.profile.update');

Route::get('/change-password', [PatientController::class, 'changePassword'])->name('patient.change.password');
Route::post('/patient/change-password', [PatientController::class, 'updatePassword'])->name('patient.change-password.update');

Route::get('login', [AuthController::class, 'patientlogin'])->name('login');
Route::get('patient-login', [AuthController::class, 'patientlogin'])->name('patient.login');
Route::get('/patient-register', [AuthController::class, 'patientregister'])->name('patient.register');
Route::post('/patient-login', [AuthController::class, 'loginpatient'])->name('patient.login.check');
Route::get('/logout-patient', [AuthController::class, 'logoutpatient'])->name('patient.logout');
Route::post('/patient/register', [AuthController::class, 'registerPatientWeb'])->name('patient.register.store');
Route::get('/booking/{id}', [PatientAppointmentController::class, 'booking'])->name('doctor.booking');
Route::get('/doctor-payment', [PatientAppointmentController::class, 'bookingpay'])->name('doctor.payment');
Route::post('/doctor-book', [PatientAppointmentController::class, 'store'])->name('doctor.book');
Route::post('/patient/subscribe-web', [PatientAppointmentController::class, 'subscribeWeb'])->name('patient.subscribe.web');
Route::get('/user/addresses', [UserAddressController::class, 'index'])->name('user.address.index');
Route::post('/user/address/store', [UserAddressController::class, 'store'])->name('user.address.store');
Route::put('/user/address/{id}', [UserAddressController::class, 'update'])->name('user.address.update');
Route::delete('/user/address/{id}', [UserAddressController::class, 'destroy'])->name('user.address.destroy');

Route::get('/patient/appointments/{appointment}', [PatientAppointmentController::class, 'show'])->middleware('auth')->name('patient.appointments.show');
Route::post('/patient/appointment/{appointment}/cancel',[PatientAppointmentController::class, 'cancel'])->name('patient.appointment.cancel');



Route::get('/admin-login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin-login', [AuthController::class, 'login'])->name('admin.login.check');

Route::middleware(['auth:web', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/patients/{patient}/book', [AdminAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments/store', [AdminAppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/doctor-slots', [AdminAppointmentController::class, 'getSlots'])->name('doctor.slots');
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/admin-logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/users/toggle-status/{id}', [AuthController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('/users', [AuthController::class, 'index'])->name('users.index');
    Route::get('/doctors', [AuthController::class, 'doctors'])->name('users.doctorsindex');
    Route::get('/doctors/{id}', [AuthController::class, 'showDoctor'])->name('doctors.show');

    Route::get('/doctors/{id}/edit', [AuthController::class, 'editDoctor'])->name('doctors.edit');
    Route::put('/doctors/{id}/update', [AuthController::class, 'updateDoctor'])->name('doctors.update');

    Route::get('doctors/{id}/payments', [DashboardController::class, 'appointments'])->name('doctors.payments');
    Route::post('doctors/{id}/pay', [DashboardController::class, 'pay'])->name('doctors.pay');

    Route::get('/appointments', [AppointmentController::class, 'adminIndex'])->name('appointments.index');
    Route::get('/specializations', [SpecializationController::class, 'index'])->name('specializations.index');
    Route::post('/specializations', [SpecializationController::class, 'store'])->name('specializations.store');
    Route::put('/specializations/{id}', [SpecializationController::class, 'update'])->name('specializations.update');
    Route::delete('/specializations/{id}', [SpecializationController::class, 'destroy'])->name('specializations.destroy');

    Route::post('/fees/store', [AppointmentFeeController::class, 'store'])->name('fees.store');
    Route::get('/fees/{doctor_id}', [AppointmentFeeController::class, 'getFee']);
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('patient-plans', PatientPlanController::class);

    Route::get('patient-plan-subscriptions', [PatientPlanSubscriptionController::class, 'index'])->name('patient-plan-subscriptions.index');

    Route::prefix('appointment-transfer-requests')->group(function () {
        Route::get('/', [AppointmentTransferRequestController::class, 'index'])->name('appointment-transfer-requests.index');
        Route::get('/{id}', [AppointmentTransferRequestController::class, 'show'])->name('appointment-transfer-requests.show');
        Route::post('/{id}/approve', [AppointmentTransferRequestController::class, 'approve'])->name('appointment-transfer-requests.approve');
        Route::post('/{id}/reject', [AppointmentTransferRequestController::class, 'reject'])->name('appointment-transfer-requests.reject');
    });
});

