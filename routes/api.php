<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\DoctorAvailabilityController;
use App\Http\Controllers\Api\DoctorDocumentController;
use App\Http\Controllers\Api\DoctorProfileController;
use App\Http\Controllers\Api\SpecializationControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


use App\Http\Controllers\Api\UserController;

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

Route::middleware(['auth:api', 'role:doctor'])->group(function () {
    Route::post('/doctor/profile', [DoctorProfileController::class, 'store']);
    Route::get('/doctor/my-profile', [DoctorProfileController::class, 'myProfile']);
    Route::delete('/doctor/profile', [DoctorProfileController::class, 'destroy']);
    
    Route::post('/doctor/document', [DoctorDocumentController::class, 'store']);
    Route::get('/doctor/documents', [DoctorDocumentController::class, 'myDocuments']);
    Route::delete('/doctor/document/{id}', [DoctorDocumentController::class, 'destroy']);
    Route::post('/doctor/availability', [DoctorAvailabilityController::class, 'store']);
    Route::get('/doctor/availability', [DoctorAvailabilityController::class, 'myAvailability']);
    Route::get('/doctor/appointments', [AppointmentController::class, 'doctorAppointments']);
});



Route::apiResource('users', UserController::class);
Route::get('/all-specializations', [SpecializationControllerApi::class,'index']);

Route::get('/doctor/profile/{doctor_id}', [DoctorProfileController::class, 'show']);

Route::post('/change-password', [UserController::class, 'changePassword']);

Route::middleware(['auth:api', 'role:patient'])->group(function () {

    
    Route::post('/appointment/book', [AppointmentController::class, 'book']);
    Route::get('/patient/appointments', [AppointmentController::class, 'patientAppointments']);

    // Cancel (both doctor & patient)
    Route::post('/appointment/{id}', [AppointmentController::class, 'cancel']);

});
