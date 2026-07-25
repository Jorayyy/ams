<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function() {
    return Auth::check() ? redirect()->route('attendance.index') : redirect()->route('welcome');
});

Route::get('/welcome', [AttendanceController::class, 'welcome'])->name('welcome');

Route::get('/login', function () {
    return Auth::check() ? redirect()->route('attendance.index') : view('attendance.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }
    return back()->withErrors(['email' => 'The provided credentials do not match our school records.']);
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('welcome');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

    Route::middleware([\App\Http\Middleware\AdminOnly::class])->group(function () {
        Route::get('/students', [AttendanceController::class, 'students'])->name('attendance.students');
        Route::post('/students', [AttendanceController::class, 'addStudent'])->name('attendance.add_student');
        Route::put('/students/{id}', [AttendanceController::class, 'updateStudent'])->name('attendance.update_student');
        Route::delete('/students/{id}', [AttendanceController::class, 'deleteStudent'])->name('attendance.delete_student');
        Route::post('/students/import', [AttendanceController::class, 'importCSV'])->name('attendance.import_csv');
        Route::get('/reports', [AttendanceController::class, 'reports'])->name('attendance.reports');
        Route::get('/reports/print/{date}', [AttendanceController::class, 'printReport'])->name('attendance.print');
        
        // Admin Dynamic Setting Controls Access Channels
        Route::get('/settings', [AttendanceController::class, 'settings'])->name('attendance.settings');
        Route::post('/settings', [AttendanceController::class, 'saveSettings'])->name('attendance.save_settings');
    });
});
