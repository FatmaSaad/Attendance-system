<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
});
Route::middleware('auth:sanctum')->group( function () {
    Route::get('attendance', [AttendanceController::class,'index']);
    Route::Post('attendance', [AttendanceController::class,'attendanceHours'])-> name('attendance_hours');
    Route::get('check_in', [AttendanceController::class,'checkIn']);
    Route::get('check_out', [AttendanceController::class,'checkOut']);
});
