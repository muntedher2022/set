<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});
Route::get('/login', fn () => redirect()->to('/admin/login'))->name('login');


// مسارات تفعيل التراخيص والتحقق والـ OTP
Route::match(['get', 'post'], '/api/license/status', [\App\Licensing\LicenseController::class, 'status']);
Route::match(['get', 'post'], '/api/license/activate', [\App\Licensing\LicenseController::class, 'activate']);
Route::match(['get', 'post'], '/api/license/request-otp-phone', [\App\Licensing\LicenseController::class, 'requestPhoneOtp']);
Route::match(['get', 'post'], '/api/license/verify-otp-phone', [\App\Licensing\LicenseController::class, 'verifyPhoneOtp']);
Route::match(['get', 'post'], '/api/license/reset', [\App\Licensing\LicenseController::class, 'reset']);
Route::match(['get', 'post'], '/api/license/deactivate', [\App\Licensing\LicenseController::class, 'reset']);
Route::match(['get', 'post'], '/license/reset', [\App\Licensing\LicenseController::class, 'reset']);
