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
use App\Http\Controllers\Admin\AdminEnquiryController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\Admin\AdminAssessmentController;
use App\Http\Controllers\Admin\AdminParameterController;
use App\Http\Controllers\Admin\AdminPatientDocumentController;

Route::get('/sitemap.xml', function () {
    try {
        $doctors = \App\Models\User::where('role', 'doctor')->get(['id', 'updated_at']);
    } catch (\Throwable $e) {
        $doctors = collect();
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";
    
    // Homepage
    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>https://physiopii.in/</loc>' . "\n";
    $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '        <changefreq>daily</changefreq>' . "\n";
    $xml .= '        <priority>1.0</priority>' . "\n";
    $xml .= '        <image:image>' . "\n";
    $xml .= '            <image:loc>https://physiopii.in/assets/img/og-preview.png</image:loc>' . "\n";
    $xml .= '            <image:title>Physiopii - Expert Physiotherapy at Home and Online</image:title>' . "\n";
    $xml .= '        </image:image>' . "\n";
    $xml .= '    </url>' . "\n";
    
    // Search Doctors
    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>https://physiopii.in/search-doctors</loc>' . "\n";
    $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '        <changefreq>daily</changefreq>' . "\n";
    $xml .= '        <priority>0.9</priority>' . "\n";
    $xml .= '    </url>' . "\n";

    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>https://physiopii.in/search</loc>' . "\n";
    $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '        <changefreq>daily</changefreq>' . "\n";
    $xml .= '        <priority>0.8</priority>' . "\n";
    $xml .= '    </url>' . "\n";

    // Dynamic Doctor profile pages
    foreach ($doctors as $doc) {
        $lastmod = $doc->updated_at ? $doc->updated_at->format('Y-m-d') : date('Y-m-d');
        $xml .= '    <url>' . "\n";
        $xml .= '        <loc>https://physiopii.in/doctor/' . $doc->id . '</loc>' . "\n";
        $xml .= '        <lastmod>' . $lastmod . '</lastmod>' . "\n";
        $xml .= '        <changefreq>weekly</changefreq>' . "\n";
        $xml .= '        <priority>0.85</priority>' . "\n";
        $xml .= '    </url>' . "\n";
    }

    // Static pages
    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>https://physiopii.in/login</loc>' . "\n";
    $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '        <changefreq>monthly</changefreq>' . "\n";
    $xml .= '        <priority>0.5</priority>' . "\n";
    $xml .= '    </url>' . "\n";

    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>https://physiopii.in/patient-register</loc>' . "\n";
    $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '        <changefreq>monthly</changefreq>' . "\n";
    $xml .= '        <priority>0.5</priority>' . "\n";
    $xml .= '    </url>' . "\n";

    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
});

Route::get('/doctor/{id}', [DoctorController::class, 'show'])->name('doctor.profile');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');
Route::get('/search-doctors', [HomeController::class, 'searchDoctors'])->name('search.doctors');
Route::get('/doctor/{id}', [HomeController::class, 'doctorProfile'])->name('doctor.profile');
Route::get('/search', [HomeController::class, 'index'])->name('search');

Route::get('/patient-dashboard', [PatientController::class, 'index'])->name('patient.dashboard');
Route::get('/patient-profile', [PatientController::class, 'profile'])->name('patient.profile');
Route::post('/patient/profile/update', [PatientController::class, 'updateProfile'])->name('patient.profile.update');

Route::get('/change-password', [PatientController::class, 'changePassword'])->name('patient.change.password');
Route::post('/patient/change-password', [PatientController::class, 'updatePassword'])->name('patient.change-password.update');

Route::get('/patient/billing-payments', [PatientController::class, 'billingPayments'])->name('patient.billing.payments');

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
    Route::get('/doctors/create', [AuthController::class, 'createDoctor'])->name('doctors.create');
    Route::post('/doctors/store', [AuthController::class, 'storeDoctor'])->name('doctors.store');
    Route::get('/doctors/{id}', [AuthController::class, 'showDoctor'])->name('doctors.show');

    Route::get('/doctors/{id}/edit', [AuthController::class, 'editDoctor'])->name('doctors.edit');
    Route::put('/doctors/{id}/update', [AuthController::class, 'updateDoctor'])->name('doctors.update');
    Route::delete('/doctors/{id}', [AuthController::class, 'destroyDoctor'])->name('doctors.destroy');

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

    Route::get('/enquiries', [AdminEnquiryController::class, 'index'])->name('enquiries.index');
    Route::post('/enquiries/{id}/status', [AdminEnquiryController::class, 'updateStatus'])->name('enquiries.updateStatus');
    Route::delete('/enquiries/{id}', [AdminEnquiryController::class, 'destroy'])->name('enquiries.destroy');

    // ── Assessments (Treatment Plans) ──────────────────────────
    Route::get('/assessments', [AdminAssessmentController::class, 'index'])->name('assessments.index');
    Route::get('/assessments/{id}', [AdminAssessmentController::class, 'show'])->name('assessments.show');

    // ── Exercise Library ────────────────────────────────────────
    Route::get('/exercises', [AdminAssessmentController::class, 'exercises'])->name('exercises.index');
    Route::post('/exercises', [AdminAssessmentController::class, 'storeExercise'])->name('exercises.store');
    Route::post('/exercises/{id}/toggle', [AdminAssessmentController::class, 'toggleExercise'])->name('exercises.toggle');
    Route::delete('/exercises/{id}', [AdminAssessmentController::class, 'destroyExercise'])->name('exercises.destroy');

    // ── Assessment Parameters Management ────────────────────────
    Route::get('/parameters', [AdminParameterController::class, 'index'])->name('parameters.index');
    Route::post('/parameters', [AdminParameterController::class, 'store'])->name('parameters.store');
    Route::post('/parameters/{id}/update', [AdminParameterController::class, 'update'])->name('parameters.update');
    Route::post('/parameters/{id}/toggle', [AdminParameterController::class, 'toggleStatus'])->name('parameters.toggle');
    Route::delete('/parameters/{id}', [AdminParameterController::class, 'destroy'])->name('parameters.destroy');

    Route::prefix('appointment-transfer-requests')->group(function () {
        Route::get('/', [AppointmentTransferRequestController::class, 'index'])->name('appointment-transfer-requests.index');
        Route::get('/{id}', [AppointmentTransferRequestController::class, 'show'])->name('appointment-transfer-requests.show');
        Route::post('/{id}/approve', [AppointmentTransferRequestController::class, 'approve'])->name('appointment-transfer-requests.approve');
        Route::post('/{id}/reject', [AppointmentTransferRequestController::class, 'reject'])->name('appointment-transfer-requests.reject');
    });

    // ── Patient Documents (Medical Reports, Prescriptions, Scans) ──
    Route::get('/patient-documents', [AdminPatientDocumentController::class, 'index'])->name('patient-documents.index');
    Route::get('/patient-documents/{id}/download', [AdminPatientDocumentController::class, 'download'])->name('patient-documents.download');
    Route::get('/patient-documents/{id}/preview', [AdminPatientDocumentController::class, 'preview'])->name('patient-documents.preview');
    Route::delete('/patient-documents/{id}', [AdminPatientDocumentController::class, 'destroy'])->name('patient-documents.destroy');

    // ── System Cache Clear (Views, Config, Cache, OPcache) ──
    Route::get('/clear-cache', function () {
        try {
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            \Illuminate\Support\Facades\Artisan::call('route:clear');
            if (function_exists('opcache_reset')) {
                @opcache_reset();
            }
            return redirect()->back()->with('success', 'View, system, and OPcache cleared successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error clearing cache: ' . $e->getMessage());
        }
    })->name('clear.cache');
});

