<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;





Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest');
Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::post('/forgot-password', [AuthenticatedSessionController::class, 'resetPassword'])
                ->middleware('guest')
                ->name('password.request');
Route::get('/resetUserPassword/', function () {
    return view('Home/changeUserPassword');
})->middleware('auth');

Route::post('/resetUserPassword', [AuthenticatedSessionController::class, 'resetUserPassword'])
                ->middleware('auth')
                ->name('userpassword.request');



Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware('auth')
                ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->middleware('auth')
                ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
                ->middleware('auth');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout');


/*--------------------------Admin----------------------*/
Route::get('/admin', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('admin');
Route::post('/admin', [AuthenticatedSessionController::class, 'adminStore']);


Route::get('/admin/logout', [AuthenticatedSessionController::class, 'adminDestroy'])
    ->middleware('authAdmin')
    ->name('admin/logout');
