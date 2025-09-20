<?php

use App\Exports\AttendanceExport;
use App\Http\Controllers\AttendanceExportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/attendance-dashboard', [AttendanceController::class, 'index'])->name('attendance.dashboard');
Route::get('/users/data', [AttendanceController::class, 'getUsersData'])->name('users.data');
Route::get('/add-user', [UserRegisterController::class, 'create'])->name('register.form');
Route::post('/register', [UserRegisterController::class, 'store'])->name('register.store');
Route::get('/attendancedata', [AttendanceController::class, 'attendanceData'])->name('attendance.data');
Route::get('/getattendancedata', [AttendanceController::class, 'getAttendanceData'])->name('getattendance.data');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/attendance/export/{filter}', [AttendanceExportController::class, 'exportAttendance'])->name('attendance.export');
// Route::get('/', [AttendanceController::class, 'index']);


Route::get('/manual', [AttendanceController::class, 'showManualForm'])->name('manual');
Route::post('/mark-attendance', [AttendanceController::class, 'markAttendance']);
Route::get('/webcam', [AttendanceController::class, 'showWebcamForm']);
Route::post('/webcam-attendance', [AttendanceController::class, 'markFromWebcam']);
