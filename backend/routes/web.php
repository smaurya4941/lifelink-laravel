<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonorProfileController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//home page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('pages.Home');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/onboarding/capabilities', [OnboardingController::class, 'edit'])->name('onboarding.capabilities.edit');
    Route::patch('/onboarding/capabilities', [OnboardingController::class, 'update'])->name('onboarding.capabilities.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read_all');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    Route::get('/map', [MapController::class, 'index'])->name('map.index');
    Route::get('/map/markers', [MapController::class, 'markers'])->name('map.markers');

    Route::get('/security', [SecurityController::class, 'dashboard'])->name('security.dashboard');
    Route::post('/security/2fa/setup', [SecurityController::class, 'setup'])->name('security.2fa.setup');
    Route::post('/security/2fa/enable', [SecurityController::class, 'enable'])->name('security.2fa.enable');
    Route::post('/security/2fa/disable', [SecurityController::class, 'disable'])->name('security.2fa.disable');
    Route::post('/security/2fa/verify', [SecurityController::class, 'verifyToken'])->name('security.2fa.verify');
    Route::post('/security/password', [SecurityController::class, 'updatePassword'])->name('security.password.update');
});

Route::middleware(['auth', 'role:recipient'])->group(function () {
    Route::get('/requests', [BloodRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [BloodRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [BloodRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{bloodRequest}', [BloodRequestController::class, 'show'])->name('requests.show');
    Route::post('/requests/{bloodRequest}/confirm', [BloodRequestController::class, 'confirmDonor'])->name('requests.confirm');
});

Route::middleware(['auth', 'role:donor'])->group(function () {
    Route::get('/matches', [DonorProfileController::class, 'matches'])->name('matches.index');
    Route::post('/matches/{match}/accept', [MatchController::class, 'accept'])->name('matches.accept');
    Route::post('/matches/{match}/reject', [MatchController::class, 'reject'])->name('matches.reject');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::get('/requests', [AdminController::class, 'requests'])->name('admin.requests');
    Route::put('/requests/{bloodRequest}', [AdminController::class, 'updateRequest'])->name('admin.requests.update');
    Route::get('/matches', [AdminController::class, 'matches'])->name('admin.matches');
    Route::put('/matches/{match}', [AdminController::class, 'updateMatch'])->name('admin.matches.update');
    Route::get('/donations', [AdminController::class, 'donations'])->name('admin.donations');
    Route::put('/donations/{donation}', [AdminController::class, 'updateDonation'])->name('admin.donations.update');
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::put('/notifications/{notification}', [AdminController::class, 'updateNotification'])->name('admin.notifications.update');
    Route::get('/hospitals', [AdminController::class, 'hospitals'])->name('admin.hospitals');
    Route::put('/hospitals/{hospital}', [AdminController::class, 'updateHospital'])->name('admin.hospitals.update');
});

Route::middleware(['auth', 'role:donor'])->group(function () {
    Route::get('/donor/profile', fn () => redirect()->route('profile.edit'))->name('donor.profile.edit');
    Route::put('/donor/profile', fn () => redirect()->route('profile.edit'))->name('donor.profile.update');

    Route::get('/donor/matches', fn () => redirect()->route('matches.index'))->name('donor.matches');
    Route::post('/donor/matches/{match}/accept', [MatchController::class, 'accept'])->name('donor.matches.accept');
    Route::post('/donor/matches/{match}/reject', [MatchController::class, 'reject'])->name('donor.matches.reject');
});

Route::middleware(['auth', 'role:recipient'])->group(function () {
    Route::get('/recipient/profile', fn () => redirect()->route('profile.edit'))->name('recipient.profile.edit');
    Route::put('/recipient/profile', fn () => redirect()->route('profile.edit'))->name('recipient.profile.update');

    Route::get('/recipient/requests', fn () => redirect()->route('requests.index'))->name('recipient.requests.index');
    Route::get('/recipient/requests/create', fn () => redirect()->route('requests.create'))->name('recipient.requests.create');
    Route::post('/recipient/requests', [BloodRequestController::class, 'store'])->name('recipient.requests.store');
    Route::get('/recipient/requests/{bloodRequest}', fn ($bloodRequest) => redirect()->route('requests.show', $bloodRequest))->name('recipient.requests.show');
    Route::post('/recipient/requests/{bloodRequest}/confirm', [BloodRequestController::class, 'confirmDonor'])->name('recipient.requests.confirm');
});

Route::middleware(['auth', 'role:hospital'])->group(function () {
    Route::get('/hospital/dashboard', [HospitalController::class, 'dashboard'])->name('hospital.dashboard');
    Route::get('/hospital/profile', [HospitalController::class, 'editProfile'])->name('hospital.profile.edit');
    Route::put('/hospital/profile', [HospitalController::class, 'updateProfile'])->name('hospital.profile.update');
    Route::get('/hospital/requests', [HospitalController::class, 'requestsIndex'])->name('hospital.requests.index');
    Route::get('/hospital/requests/create', [HospitalController::class, 'createRequest'])->name('hospital.requests.create');
    Route::post('/hospital/requests', [HospitalController::class, 'storeRequest'])->name('hospital.requests.store');
    Route::get('/hospital/requests/{bloodRequest}', [HospitalController::class, 'showRequest'])->name('hospital.requests.show');
});

require __DIR__.'/auth.php';
