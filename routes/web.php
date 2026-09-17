<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListMemberController;
use App\Http\Controllers\ListProgressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard-admin', function () {
        return view('dashboard_admin');
    });

    Route::get('/dashboard-user', function () {
        return view('dashboard_user');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // SRS-06: Kolaborasi List — Kelola member dalam list
    Route::get('/lists/{list}/members', [ListMemberController::class, 'index'])
        ->name('lists.members.index');

    Route::post('/lists/{list}/members', [ListMemberController::class, 'store'])
        ->name('lists.members.store');

    Route::delete('/lists/{list}/members/{user}', [ListMemberController::class, 'destroy'])
        ->name('lists.members.destroy');

    // SRS-07: Monitoring Progress — Pantau progres penyelesaian tugas
    Route::get('/lists/{list}/progress', [ListProgressController::class, 'show'])
        ->name('lists.progress');


    // SRS-08: Manajemen User oleh Admin
    Route::get('/admin/users', [AdminUserController::class, 'index'])
        ->name('admin.users.index');

    Route::get('/admin/users/create', [AdminUserController::class, 'create'])
        ->name('admin.users.create');

    Route::post('/admin/users', [AdminUserController::class, 'store'])
        ->name('admin.users.store');

    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])
        ->name('admin.users.destroy');

    // SRS-02: Manajemen List/Project
    Route::resource('lists', ListController::class);

    // SRS-03, SRS-04, SRS-05: Manajemen Tugas
    Route::post('lists/{list}/tasks', [TaskController::class, 'store'])
        ->name('tasks.store');

    Route::get('lists/{list}/tasks/create', [TaskController::class, 'create'])
        ->name('tasks.create');

    Route::get('lists/{list}/tasks/{task}/edit', [TaskController::class, 'edit'])
        ->name('tasks.edit');

    Route::put('lists/{list}/tasks/{task}', [TaskController::class, 'update'])
        ->name('tasks.update');

    Route::patch('lists/{list}/tasks/{task}/toggle', [TaskController::class, 'toggle'])
        ->name('tasks.toggle');

    Route::delete('lists/{list}/tasks/{task}', [TaskController::class, 'destroy'])
        ->name('tasks.destroy');
});