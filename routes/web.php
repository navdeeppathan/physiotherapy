<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\AppointmentFeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SpecializationController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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

//user apis



//admin 

// Route::get('/admin-register', [AuthController::class, 'showRegister'])->name('admin.register');
// Route::post('/admin-register', [AuthController::class, 'register'])->name('admin.register.store');

Route::get('/admin-login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin-login', [AuthController::class, 'login'])->name('admin.login.check');


Route::middleware(['auth:web', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Route::get('/dashboard', [AdminDashboardController::class,'index'])
    //     ->name('dashboard');
    Route::post('/admin-logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/users/toggle-status/{id}', [AuthController::class, 'toggleStatus']);
    Route::get('/users', [AuthController::class, 'index'])->name('users.index');
    Route::get('/appointments', [AppointmentController::class, 'adminIndex'])
      ->name('appointments.index');

    Route::get('/specializations', [SpecializationController::class,'index'])->name('specializations.index');

    Route::post('/specializations', [SpecializationController::class,'store'])->name('specializations.store');

    Route::put('/specializations/{id}', [SpecializationController::class,'update'])->name('specializations.update');

    Route::delete('/specializations/{id}', [SpecializationController::class,'destroy'])->name('specializations.destroy');
  

    Route::post('/fees/store', [AppointmentFeeController::class, 'store'])->name('fees.store');
    Route::get('/fees/{doctor_id}', [AppointmentFeeController::class, 'getFee']);
    // Route::get('/dashboard', function () {
    //     return view('admin.dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

