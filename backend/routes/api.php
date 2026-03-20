<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\DonorController;
use App\Http\Controllers\Api\RecipientController;
use App\Http\Controllers\Api\BloodRequestController;
use App\Http\Controllers\Api\MatchController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\SecurityController;
use App\Http\Controllers\Api\NearbyController;
use App\Http\Controllers\Api\MapController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DonationController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/token/refresh', [AuthController::class, 'refresh']);
Route::post('/password-reset', [PasswordResetController::class, 'requestReset']);
Route::post('/password-reset/confirm', [PasswordResetController::class, 'confirmReset']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', [DashboardController::class, 'show']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::patch('/profile', [ProfileController::class, 'update']);

    Route::get('/donors', [DonorController::class, 'index']);
    Route::post('/donors', [DonorController::class, 'store']);
    Route::patch('/donors/{donor}', [DonorController::class, 'update']);
    Route::get('/donors/available_donors', [DonorController::class, 'available']);

    Route::get('/recipients', [RecipientController::class, 'index']);
    Route::post('/recipients', [RecipientController::class, 'store']);
    Route::patch('/recipients/{recipient}', [RecipientController::class, 'update']);

    Route::get('/blood-requests', [BloodRequestController::class, 'index']);
    Route::post('/blood-requests', [BloodRequestController::class, 'store']);
    Route::get('/blood-requests/{bloodRequest}', [BloodRequestController::class, 'show']);
    Route::patch('/blood-requests/{bloodRequest}', [BloodRequestController::class, 'update']);
    Route::delete('/blood-requests/{bloodRequest}', [BloodRequestController::class, 'destroy']);
    Route::post('/blood-requests/{bloodRequest}/find_matches', [BloodRequestController::class, 'findMatches']);
    Route::post('/blood-requests/{bloodRequest}/confirm_donor', [BloodRequestController::class, 'confirmDonor']);

    Route::get('/matches', [MatchController::class, 'index']);
    Route::post('/matches/{match}/accept', [MatchController::class, 'accept']);
    Route::post('/matches/{match}/reject', [MatchController::class, 'reject']);

    Route::get('/donation-history', [DonationController::class, 'index']);
    Route::post('/donation-history', [DonationController::class, 'store']);
    Route::get('/donation-history/{donation}', [DonationController::class, 'show']);
    Route::patch('/donation-history/{donation}', [DonationController::class, 'update']);
    Route::delete('/donation-history/{donation}', [DonationController::class, 'destroy']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{notification}/mark_read', [NotificationController::class, 'markRead']);
    Route::post('/notifications/mark_all_read', [NotificationController::class, 'markAllRead']);

    Route::get('/analytics', [AnalyticsController::class, 'index']);
    Route::get('/analytics/predictive', [AnalyticsController::class, 'predictive']);

    Route::get('/security/2fa/setup', [SecurityController::class, 'setup']);
    Route::post('/security/2fa/enable', [SecurityController::class, 'enable']);
    Route::post('/security/2fa/verify', [SecurityController::class, 'verify']);
    Route::post('/security/2fa/disable', [SecurityController::class, 'disable']);
    Route::get('/security/dashboard', [SecurityController::class, 'dashboard']);
    Route::post('/security/password', [SecurityController::class, 'updatePassword']);

    Route::get('/nearby/donors', [NearbyController::class, 'donors']);
    Route::get('/nearby/requests', [NearbyController::class, 'requests']);

    Route::get('/map/data', [MapController::class, 'data']);
});
