<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ClientsContactsController;


Route::get('/', [AuthController::class, 'Index'])->name('home');

Route::get('/password-request', [AuthController::class, 'Password_Request'])->name('password.request');

Route::get('/dashboard', [AuthController::class, 'Dashboard'])->name('dashboard')->middleware(['auth', 'verified']);

Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');

Route::get('/registration', [RegistrationController::class, 'Index'])->name('register');

Route::get('/email/verify', [RegistrationController::class, 'ResendingVerificationPage'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [RegistrationController::class, 'verifyEmail'])->name('verification.verify')->middleware('signed');

Route::get('/login', [RegistrationController::class, 'RedirectLogin'])->name('login');


Route::post('/login', [AuthController::class, 'loginAjax'])->name('login.ajax');

Route::post('/recovery-pass', [AuthController::class, 'RecoveryPassword'])->name('recoverypass.ajax');

Route::post('/password/reset', [AuthController::class, 'ResetPassword'])->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::post('/email/verification-notification', [RegistrationController::class, 'ResendLink'])->name('verification.send');

Route::post('/registration-ajax', [RegistrationController::class, 'registrationAjax'])->name('registration.ajax');


Route::get('/dashboard/home', fn () => view('static.dashboard.pages.home'));
Route::get('/dashboard/clients', fn () => view('static.dashboard.pages.clients'));

Route::get('/dashboard/contacts', [ClientsContactsController::class, 'showPage'])->name('contacts');

Route::get('/api/dashboard/clients', [ClientsController::class, 'index']);

Route::get('/api/dashboard/contacts', [ClientsContactsController::class, 'index']);

Route::prefix('dashboard/clients')->name('dashboard.clients.')->group(function () {
    
    Route::get('/create', [ClientsController::class, 'create'])->name('create');

    Route::post('/store', [ClientsController::class, 'store'])->name('store');

    Route::get('/client/{client}', [ClientsController::class, 'show'])->name('show');

    Route::get('{client}/edit', [ClientsController::class, 'edit'])->name('edit');

    Route::put('{client}', [ClientsController::class, 'update'])->name('update');

   

});

Route::prefix('dashboard/contacts')->name('dashboard.contacts.')->group(function () {
    
    Route::get('/create', [ClientsContactsController::class, 'create'])->name('create');

    Route::post('/store', [ClientsContactsController::class, 'store'])->name('store');

    Route::get('{contact}/edit', [ClientsContactsController::class, 'edit'])->name('edit');

    Route::put('{contact}', [ClientsContactsController::class, 'update'])->name('update');

});



Route::delete('/api/dashboard/clients/{client}', [ClientsController::class, 'destroy']);
Route::delete('/api/dashboard/contacts/{contact}', [ClientsContactsController::class, 'destroy']);
