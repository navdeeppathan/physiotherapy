<?php

// use App\Http\Controllers\Api\AppointmentController;
// use App\Http\Controllers\Api\DoctorAvailabilityController;
// use App\Http\Controllers\Api\DoctorDocumentController;
// use App\Http\Controllers\Api\DoctorProfileController;
// use App\Http\Controllers\Api\FeedbackController;
// use App\Http\Controllers\Api\SpecializationControllerApi;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "api" middleware group. Make something great!
// |
// */


// use App\Http\Controllers\Api\UserController;

// Route::post('/login', [UserController::class, 'login']);
// Route::post('/login-patient', [UserController::class, 'loginPatient']);


// Route::post('/verify-otp', [UserController::class, 'verifyOtp']);
// Route::post('/logout', [UserController::class, 'logout']);

// Route::post('/register-patient', [UserController::class, 'registerPatient']);


// Route::get('/doctors', [UserController::class, 'doctors']);
// Route::get('/doctor/slots/{doctor_id}', [DoctorAvailabilityController::class, 'getSlotsByDoctorId']);

// Route::post('/feedback', [FeedbackController::class, 'store']);
// Route::get('/doctor/{doctor_id}/feedback', [FeedbackController::class, 'getDoctorFeedback']);
// Route::get('/doctor/{doctor_id}/rating', [FeedbackController::class, 'getDoctorRating']);

// use App\Http\Controllers\Api\PlanController;

// Route::prefix('plans')->group(function () {
//     Route::get('/', [PlanController::class, 'index']);      // GET all plans
//     Route::post('/', [PlanController::class, 'store']);     // Create plan
//     Route::get('{id}', [PlanController::class, 'show']);    // Get single plan
//     Route::put('{id}', [PlanController::class, 'update']);  // Update plan
//     Route::delete('{id}', [PlanController::class, 'destroy']); // Delete plan
// });

// Route::middleware(['auth:api', 'role:doctor'])->group(function () {
//     Route::post('/doctor/profile', [DoctorProfileController::class, 'store']);
//     Route::get('/doctor/my-profile', [DoctorProfileController::class, 'myProfile']);
//     Route::delete('/doctor/profile', [DoctorProfileController::class, 'destroy']);
    
//     Route::post('/doctor/document', [DoctorDocumentController::class, 'store']);
//     Route::get('/doctor/documents', [DoctorDocumentController::class, 'myDocuments']);
//     Route::delete('/doctor/document/{id}', [DoctorDocumentController::class, 'destroy']);
//     Route::post('/doctor/availability', [DoctorAvailabilityController::class, 'store']);
//     Route::get('/doctor/availability', [DoctorAvailabilityController::class, 'myAvailability']);
//     Route::get('/doctor/availability/slots', [DoctorAvailabilityController::class, 'getSlotsByDate']);
//     Route::delete('/doctor/time-slots/{id}', [DoctorAvailabilityController::class, 'destroySlots']);
//     Route::get('/doctor/appointments', [AppointmentController::class, 'doctorAppointments']);

//     Route::post('/doctor/appointments/{id}/action', [AppointmentController::class, 'handleAction']);
//     // routes/api.php
//     Route::get('/doctor/{doctor_id}/wallet', [AppointmentController::class, 'getDoctorWallet']);

//     Route::get('doctor/payment-history/{doctorId}', [UserController::class, 'doctorPaymentHistory']);

// });



// Route::apiResource('users', UserController::class);
// Route::get('/all-specializations', [SpecializationControllerApi::class,'index']);

// Route::get('/find-doctors', [SpecializationControllerApi::class, 'findDoctors']);

// Route::get('/doctor/profile/{doctor_id}', [DoctorProfileController::class, 'show']);

// Route::post('/change-password', [UserController::class, 'changePassword']);


// use App\Http\Controllers\Api\UserSubscriptionController;

// Route::get('/subscriptions', [UserSubscriptionController::class, 'index']);
// Route::get('/my-subscription', [UserSubscriptionController::class, 'mySubscription']);
// Route::post('/subscribe', [UserSubscriptionController::class, 'store']);
// Route::post('/cancel-subscription', [UserSubscriptionController::class, 'cancel']);

    
// use App\Http\Controllers\Api\PatientPlanController;

// Route::get('/patient-plans', [PatientPlanController::class, 'index']);

// Route::post('/patient-plans/subscribe', [PatientPlanController::class, 'subscribe']);

// // (Optional - cron endpoint)
// Route::get('/expire-subscriptions', [UserSubscriptionController::class, 'expireSubscriptions']);




// Route::middleware(['auth:api', 'role:patient'])->group(function () {

    
//     Route::post('/appointment/book', [AppointmentController::class, 'book']);
//     Route::get('/patient/appointments', [AppointmentController::class, 'patientAppointments']);

//     // Cancel (both doctor & patient)
//     Route::post('/appointment/{id}', [AppointmentController::class, 'cancel']);

//     Route::post('/update-patient/{id}', [UserController::class, 'updatePatient']);
//     Route::get('/patient/{id}/payments', [UserController::class, 'patientPaymentHistory']);

// });


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\DoctorAvailabilityController;
use App\Http\Controllers\Api\DoctorDocumentController;
use App\Http\Controllers\Api\DoctorProfileController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\SpecializationControllerApi;
use App\Http\Controllers\Api\UserSubscriptionController;
use App\Http\Controllers\Api\PatientPlanController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Authentication
Route::post('/login', [UserController::class, 'login']);
Route::post('/login-patient', [UserController::class, 'loginPatient']);
Route::post('/verify-otp', [UserController::class, 'verifyOtp']);
Route::post('/register-patient', [UserController::class, 'registerPatient']);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::post('users', [UserController::class, 'store']);

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [UserController::class, 'logout']);

    // Users
     Route::apiResource('users', UserController::class)->except(['store']);

    Route::post('/change-password', [UserController::class, 'changePassword']);

    // Doctors Listing
    Route::get('/doctors', [UserController::class, 'doctors']);
    Route::get('/doctor/profile/{doctor_id}', [DoctorProfileController::class, 'show']);
    Route::get('/doctor/slots/{doctor_id}', [DoctorAvailabilityController::class, 'getSlotsByDoctorId']);

    // Feedback
    Route::post('/feedback', [FeedbackController::class, 'store']);
    Route::get('/doctor/{doctor_id}/feedback', [FeedbackController::class, 'getDoctorFeedback']);
    Route::get('/doctor/{doctor_id}/rating', [FeedbackController::class, 'getDoctorRating']);

    // Specializations
    Route::get('/all-specializations', [SpecializationControllerApi::class, 'index']);
    Route::get('/find-doctors', [SpecializationControllerApi::class, 'findDoctors']);

    // Plans
    Route::prefix('plans')->group(function () {
        Route::get('/', [PlanController::class, 'index']);
        Route::post('/', [PlanController::class, 'store']);
        Route::get('{id}', [PlanController::class, 'show']);
        Route::put('{id}', [PlanController::class, 'update']);
        Route::delete('{id}', [PlanController::class, 'destroy']);
    });

    // Subscriptions
    Route::get('/subscriptions', [UserSubscriptionController::class, 'index']);
    Route::get('/my-subscription', [UserSubscriptionController::class, 'mySubscription']);
    Route::post('/subscribe', [UserSubscriptionController::class, 'store']);
    Route::post('/cancel-subscription', [UserSubscriptionController::class, 'cancel']);

    // Patient Plans
    Route::get('/patient-plans', [PatientPlanController::class, 'index']);
    Route::post('/patient-plans/subscribe', [PatientPlanController::class, 'subscribe']);

    // Expire subscriptions
    Route::get('/expire-subscriptions', [UserSubscriptionController::class, 'expireSubscriptions']);
    Route::post('/appointment/{id}/cancel', [AppointmentController::class, 'cancel']);

    Route::get(
    '/cancellation-reasons',
    [AppointmentController::class, 'getCancellationReasons']
);
});



Route::middleware(['auth:api', 'role:doctor'])->group(function () {

    Route::get('/doctor/{doctorId}/patients', [UserController::class, 'doctorPatients']);

    Route::post('/doctor/profile', [DoctorProfileController::class, 'store']);
    Route::get('/doctor/my-profile', [DoctorProfileController::class, 'myProfile']);
    Route::delete('/doctor/profile', [DoctorProfileController::class, 'destroy']);

    Route::post('/doctor/document', [DoctorDocumentController::class, 'store']);
    Route::get('/doctor/documents', [DoctorDocumentController::class, 'myDocuments']);
    Route::delete('/doctor/document/{id}', [DoctorDocumentController::class, 'destroy']);

    Route::post('/doctor/availability', [DoctorAvailabilityController::class, 'store']);
    Route::get('/doctor/availability', [DoctorAvailabilityController::class, 'myAvailability']);
    Route::get('/doctor/availability/slots', [DoctorAvailabilityController::class, 'getSlotsByDate']);
    Route::delete('/doctor/time-slots/{id}', [DoctorAvailabilityController::class, 'destroySlots']);

    Route::get('/doctor/appointments', [AppointmentController::class, 'doctorAppointments']);
    Route::post('/doctor/appointments/{id}/action', [AppointmentController::class, 'handleAction']);

    Route::get('/doctor/{doctor_id}/wallet', [AppointmentController::class, 'getDoctorWallet']);
    Route::get('/doctor/payment-history/{doctorId}', [UserController::class, 'doctorPaymentHistory']);

    Route::post('/doctor/appointments/{id}/reschedule', [AppointmentController::class, 'reschedule']);

    Route::get('/doctor/appointments/upcoming', [AppointmentController::class, 'doctorUpcomingAppointments']);

    Route::get('/doctor/appointments/completed', [AppointmentController::class, 'doctorCompletedAppointments']);
    Route::get('/doctor/cancelled-appointments', [AppointmentController::class, 'doctorCancelledAppointments']);

    Route::get('/doctor/appointments/shifted', [AppointmentController::class, 'doctorShiftedAppointments']);
});


Route::middleware(['auth:api', 'role:patient'])->group(function () {

    Route::post('/appointment/book', [AppointmentController::class, 'book']);
    Route::get('/patient/appointments', [AppointmentController::class, 'patientAppointments']);


    Route::post('/update-patient/{id}', [UserController::class, 'updatePatient']);
    Route::get('/patient/{id}/payments', [UserController::class, 'patientPaymentHistory']);

    Route::get('/patient/appointments/upcoming', [AppointmentController::class, 'patientUpcomingAppointments']);

    Route::get('/patient/appointments/completed', [AppointmentController::class, 'patientCompletedAppointments']);
    Route::get('/patient/cancelled-appointments', [AppointmentController::class, 'patientCancelledAppointments']);

    Route::get('/patient/appointments/shifted', [AppointmentController::class, 'patientShiftedAppointments']);
});