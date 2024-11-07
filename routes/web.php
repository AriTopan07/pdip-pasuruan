<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\ButtonController;
use App\Http\Controllers\Data\FormController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

// Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');

Route::get('login', [LoginController::class, 'login']);
Route::post('login', [LoginController::class, 'check_login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// URL::forceScheme('https');
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Route::get('/create-section', [SectionController::class, 'section']);
    Route::get('/section/edit/{id}', [SectionController::class, 'edit']);
    Route::post('/section/update/{id}', [SectionController::class, 'update']);
    Route::post('/section/store', [SectionController::class, 'store']);

    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::post('users/update/{id}', [UserController::class, 'update'])->name('users.update');

    // Group
    Route::get('group', [GroupController::class, 'index'])->name('group.index');
    Route::post('group/store', [GroupController::class, 'store'])->name('group.store');
    Route::get('group/{id}', [GroupController::class, 'show'])->name('group.show');
    Route::put('group/{id}', [GroupController::class, 'update'])->name('group.update');
    Route::delete('group/{id}', [GroupController::class, 'destroy'])->name('group.delete');

    // Menu
    Route::get('/menu/api/{id}', [MenuController::class, 'menuApi']);
    Route::post('/menu/store', [MenuController::class, 'store']);
    Route::post('/menu/update/{id}', [MenuController::class, 'update']);

    // Master Aksi
    Route::get('action', [ActionController::class, 'index'])->name('action.index');
    Route::post('action/store', [ActionController::class, 'store'])->name('action.store');

    // Button
    Route::get('button', [ButtonController::class, 'index'])->name('button.index');
    Route::post('button', [ButtonController::class, 'update'])->name('button.update');

    // Hak Akses Menu
    Route::get('permission/data-akses/{id}', [PermissionController::class, 'data_akses'])->name('permission.data-akses');
    Route::post('permission/data-akses/edit_akses', [PermissionController::class, 'edit_akses'])->name('permission.edit-akses');
    Route::post('permission/data-akses/all_access', [PermissionController::class, 'all_access'])->name('permission.all-akses');

    Route::get('/form-tambah-data', [FormController::class, 'view'])->name('formulir.view');
    Route::post('/form-tambah-data', [FormController::class, 'store'])->name('formulir.store');
});
