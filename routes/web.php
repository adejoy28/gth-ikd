<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});

use App\Http\Controllers\BorrowRequestController;

Route::middleware(['auth'])->group(function () {
    Route::get('/borrow-requests', [BorrowRequestController::class, 'index'])->name('borrow_requests.index');
    Route::get('/borrow-requests/create', [BorrowRequestController::class, 'create'])->name('borrow_requests.create');
    Route::post('/borrow-requests', [BorrowRequestController::class, 'store'])->name('borrow_requests.store');

    // Admin actions
    Route::middleware('can:isAdmin')->group(function () {
        Route::post('/borrow-requests/{id}/approve', [BorrowRequestController::class, 'approve'])->name('borrow_requests.approve');
        Route::post('/borrow-requests/{id}/deny', [BorrowRequestController::class, 'deny'])->name('borrow_requests.deny');
        Route::post('/borrow-requests/{id}/returned', [BorrowRequestController::class, 'markReturned'])->name('borrow_requests.returned');
    });
});


require __DIR__.'/auth.php';
