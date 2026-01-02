<?php

use Illuminate\Support\Facades\Route;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjetController;


Route::get('/', function () {return view('home');})->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard/chef', [DashboardController::class, 'chef'])->name('dashboard.chef');
    Route::get('/projects', [ProjetController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjetController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjetController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjetController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjetController::class, 'update'])->name('projects.update');
    Route::post('/projects/{project}/archive', [ProjetController::class, 'archive'])->name('projects.archive');
    Route::delete('/projects/{project}', [ProjetController::class, 'destroy'])->name('projects.destroy');
   Route::post('/projects/{project}/favorite',[ProjetController::class, 'toggleFavorite'])->name('projects.favorite');
    Route::post('/{project}/add-supervisor', [ProjetController::class, 'addSupervisor'])
         ->name('projects.updateSupervisor');
   Route::prefix('chef')->group(function() {
        Route::get('/home', [DashboardController::class, 'index'])->name('chef.home');
        Route::get('/projects', [DashboardController::class, 'projects'])->name('chef.projects');
        Route::get('/team', [DashboardController::class, 'team'])->name('chef.team');
        Route::get('/settings', [DashboardController::class, 'settings'])->name('chef.settings');
    });
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/supervisor', [DashboardController::class, 'supervisor'])->name('dashboard.supervisor');
    Route::get('/dashboard/member', [DashboardController::class, 'member'])->name('dashboard.member');


