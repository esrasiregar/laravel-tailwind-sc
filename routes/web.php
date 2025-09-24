<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ==================== Dashboard Routing ====================

Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'staff' => redirect()->route('staff.dashboard'),
        'client' => redirect()->route('client.dashboard'),
        default => redirect('/login'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// ==================== Dashboard Routing ====================



// ==================== Admin Routing ====================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/admin', fn() => view('admin.dashboard'))->name('dashboard');
});

// ==================== Admin Routing ====================



// ==================== Staff Routing ====================

Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/staff', fn() => view('staff.dashboard'))->name('dashboard');
});

// ==================== Staff Routing ====================



// ==================== Client Routing ====================

Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/client', fn() => view('client.dashboard'))->name('dashboard');
});

// ==================== Client Routing ====================


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';