<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/forgotpw', function (Request $request) {
    $credentials = $request->only('email');

    $response = Password::sendResetLink($credentials);

    return $response == Password::RESET_LINK_SENT
                ? response()->json(['status' => __($response)], 200)
                : response()->json(['email' => __($response)], 400);
});

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');