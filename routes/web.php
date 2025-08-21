<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Landing page (tracking page)
Route::get('/', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/track', [TrackingController::class, 'track'])->name('tracking.track');

// User routes
Route::get('/order', [UserController::class, 'index'])->name('user.order-form');
Route::post('/order', [UserController::class, 'store'])->name('user.store');

// Admin routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.authenticate');

// Protected admin routes
Route::middleware(['App\Http\Middleware\AdminAuth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::post('/admin/mark-completed', [AdminController::class, 'markCompleted'])->name('admin.mark-completed');
    Route::post('/admin/update-status', [AdminController::class, 'updateStatus'])->name('admin.update-status');
    Route::post('/admin/update-tracking-ids', [AdminController::class, 'updateTrackingIds'])->name('admin.update-tracking-ids');
    Route::post('/admin/print-invoices', [AdminController::class, 'printInvoices'])->name('admin.print-invoices');
    Route::put('/admin/orders/{order}', [AdminController::class, 'updateOrder'])->name('admin.update-order');
    Route::delete('/admin/delete-orders', [AdminController::class, 'deleteOrders'])->name('admin.delete-orders');
});
