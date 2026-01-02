<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbonnementController;

Route::get('/', function () {
    return view('home');
})->name('home'); 

// GET /abonnements  →  AbonnementController@index_abonnement
Route::get('/abonnements', [AbonnementController::class, 'index_abonnement'])
    ->name('abonnements.index');

Route::post('/abonnements/choisir', [AbonnementController::class, 'choose'])
    ->name('abonnements.choose');

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Dashboard routes
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard/chef', [DashboardController::class, 'chef'])->
    name('dashboard.chef');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->
    name('dashboard.admin');
    
});


Route::get('/dashboard/supervisor', [DashboardController::class, 'supervisor'])->
name('dashboard.supervisor');
Route::get('/dashboard/member', [DashboardController::class, 'member'])->name('dashboard.member');

Route::prefix('chef')->middleware(['auth'])->group(function() {
    Route::get('/home', [DashboardController::class, 'index'])->name('chef.home');
    Route::get('/projects', [DashboardController::class, 'projects'])->name('chef.projects');
    Route::get('/team', [DashboardController::class, 'team'])->name('chef.team');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('chef.settings');
});
