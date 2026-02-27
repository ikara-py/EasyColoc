<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    Route::post('/colocations/generate-invite', [ColocationController::class, 'generateInvite'])->name('colocations.generate_invite');

    Route::post('/colocations/join', [ColocationController::class, 'join'])->name('colocations.join');
    Route::post('/colocations/generate-invite', [ColocationController::class, 'generateInvite'])->name('colocations.generate_invite');
    Route::delete('/colocations/deactivate', [ColocationController::class, 'deactivate'])->name('colocations.deactivate');
    Route::delete('/colocations/members/{user}', [ColocationController::class, 'removeMember'])->name('colocations.remove_member');
    Route::delete('/colocations/leave', [ColocationController::class, 'leave'])->name('colocations.leave');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::patch('/expenses/{expense}/settle', [ExpenseController::class, 'settle'])->name('expenses.settle');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/ban', [AdminController::class, 'banUser'])->name('users.ban');
    Route::post('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('users.unban');
});

require __DIR__ . '/auth.php';
