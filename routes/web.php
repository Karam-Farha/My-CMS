<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuditLogsController;

// Route::get('/login', function () {
//     return redirect()->route('login');    
//     // return redirect()->route('dashboard.home');    
// });


Route::middleware(Localization::class)->group(function(){
    
    Route::get('/' , [WebsiteController::class , 'index'])->name('website-home');
    
    Route::get('/localization/{local}' , LocalizationController::class )->name('localization');

    Route::prefix('admin')->middleware(['role:Admin'])->group(function () {
    
        //Dashboard
        Route::view('index' , 'Admin.index')->name('Admin.home');
    
        Route::get('user-profile' , function(){
    
        return view('Admin.users-profile')->with(['email' => auth()->user()->email]);})->name('user-profile');
    
        // USERS ROUTES
        Route::resource('users' , 'App\Http\Controllers\Admin\UserController');
    
        
        // Route::view('user-profile', 'dashboard.users-profile')->name('user-profile');
        // Route::view('pages-login', 'dashboard.pages-login')->name('login');
        // Route::view('pages-register', 'dashboard.pages-register')->name('register');
    });
    
    Route::resource('audit-logs', AuditLogsController::class)->only(['index']);

    Auth::routes();
    
    Route::post('/otp/verify', [RegisterController::class , 'otpVerfication'])->name('opt-verifiy');
    Route::post('/otp/resend', [RegisterController::class , 'otpResend'])->name('opt-resend');
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

