<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResearcherController;
use App\Http\Controllers\ReportController;


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


Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Add-Admin
    Route::get('/add/admin', [AdminController::class, 'index'])->name('admin.add');
    Route::post('/add/admin', [AdminController::class, 'store'])->name('admin.store');
    // Specialization
    Route::get('/add/specialization', [SpecializationController::class, 'create'])->name('specialization.add');
    Route::post('/add/specialization', [SpecializationController::class, 'store'])->name('specialization.store');
    Route::get('/show/specialization', [SpecializationController::class, 'show'])->name('specialization.show');
    // Company
    Route::get('/show/company', [CompanyController::class, 'show'])->name('company.show');
    Route::get('/profile/company/{uuid}', [CompanyController::class, 'profile'])->name('company.profile');
    Route::get('/reports/company/{uuid}', [CompanyController::class, 'reports'])->name('company.reports');
    // Report
    Route::post('/status/update/{id}', [ReportController::class, 'update'])->name('status.update');
    Route::post('/report/details/{uuid}/{id}', [ReportController::class, 'details'])->name('report.details');
    // Researcher
    Route::get('/show/researcher', [ResearcherController::class, 'show'])->name('researcher.show');
    Route::get('/profile/researcher/{uuid}', [ResearcherController::class, 'profile'])->name('researcher.profile');
    Route::get('/reports/researcher/{uuid}', [ResearcherController::class, 'reports'])->name('researcher.reports');
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/save/profile', [ProfileController::class, 'save'])->name('profile.save');
});

Auth::routes();
