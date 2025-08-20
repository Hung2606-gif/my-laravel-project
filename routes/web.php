<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ReportController;

// Home route
Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

// Login & Authentication
Route::get('/login', [LoginController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login'); 
})->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);


// Password Reset
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Confirm Password
    Route::get('/confirm-password', fn() => view('auth.confirm-password'))->name('password.confirm');
   
   // routes/web.php
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/data', [UserController::class, 'getUsersData'])->name('users.data');

    // Trang danh sách các phòng ban (hiển thị nút)
Route::get('/departments', [DepartmentController::class, 'view'])->name('departments.view');
Route::get('/department/{department?}', [DepartmentController::class, 'show'])->name('departments.store');


// Hiển thị form thêm phòng ban
Route::get('/department/create', [DepartmentController::class, 'create'])->name('departments.create');

// Xử lý lưu phòng ban mới (submit form)
Route::post('/department/store', [DepartmentController::class, 'store'])->name('departments.store');


Route::delete('/departments/{id}', [DepartmentController::class, 'delete'])->name('departments.destroy');
Route::delete('/users/{id}/delete', [UserController::class, 'deleteUser'])->name('users.delete');

Route::get('users/managers', [ UserController::class, 'managersView'])->name('users.managers');
Route::get('/managers/{id}/destroy', [UserController::class, 'managersDelete'])->name('users.managerDestroy');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');


Route::get('/projects/index', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects/data', [ProjectController::class, 'data'])->name('projects.data');
Route::get('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
Route::match(['get', 'post'], '/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');

Route::get('/reports/index', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports/store', [ReportController::class, 'store'])->name('reports.store');
Route::get('/reports/data', [ReportController::class, 'data'])->name('reports.data');
Route::get('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
Route::match(['get', 'post'], '/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');

Route::get('/users/export/csv', [App\Http\Controllers\UserController::class, 'exportCsv'])->name('users.export.csv');




   

    // Users
    Route::resource('users', UserController::class);
   
    

  
});















