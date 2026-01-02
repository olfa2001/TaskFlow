<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('home');
})->name('home'); 

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard routes
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard/chef', [DashboardController::class, 'chef'])->name('dashboard.chef');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/supervisor', [DashboardController::class, 'supervisor'])->name('dashboard.supervisor');
    Route::get('/dashboard/member', [DashboardController::class, 'member'])->name('dashboard.member');
});

Route::prefix('chef')->middleware(['auth'])->group(function() {
    Route::get('/settings/profile', [ProfileController::class, 'index'])->name('chef.profile');
    Route::post('/settings/update-bio', [ProfileController::class, 'updateBio'])->name('chef.updateBio');

    Route::get('/projects', [DashboardController::class, 'projects'])->name('chef.projects');
    Route::get('/team', [DashboardController::class, 'team'])->name('chef.team');
    Route::get('/settings', [SettingsController::class, 'index'])->name('chef.settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('chef.settings.update');

    // Placeholder routes for sidebar links
    Route::get('/tasks', [DashboardController::class, 'index'])->name('chef.tasks');
    Route::get('/reports', [DashboardController::class, 'index'])->name('chef.reports');
    Route::get('/messages', [DashboardController::class, 'index'])->name('chef.messages');
});

   
