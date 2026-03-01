<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettlementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');

    Route::post('/colocations/join', [ColocationController::class, 'join'])->name('colocations.join');
    Route::delete('/colocations/deactivate', [ColocationController::class, 'deactivate'])->name('colocations.deactivate');
    Route::delete('/colocations/members/{user}', [ColocationController::class, 'removeMember'])->name('colocations.remove_member');
    Route::delete('/colocations/leave', [ColocationController::class, 'leave'])->name('colocations.leave');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::patch('/expenses/{expense}/settle', [ExpenseController::class, 'settle'])->name('expenses.settle');
    Route::get('/expenses/{expense}', [ExpenseController::class, 'show'])->name('expenses.show');
    Route::post('/expenses/{expense}/mark-paid/{user}', [SettlementController::class, 'store'])->name('expenses.mark_paid');
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/colocations/send-invite', [ColocationController::class, 'sendInvite'])->name('colocations.send_invite');
    Route::get('/invitations/{token}/accept', [ColocationController::class, 'acceptInvite'])->name('invitations.accept');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/ban', [AdminController::class, 'ban'])->name('users.ban');
    Route::post('/users/{user}/unban', [AdminController::class, 'unban'])->name('users.unban');
});

require __DIR__ . '/auth.php';
