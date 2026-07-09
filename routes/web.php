<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TypeOfServiceController;
use App\Http\Controllers\TransOrderController;
use App\Http\Controllers\TransLaundryPickupController;
use App\Http\Controllers\ReportController;


// Halaman publik (tidak butuh login)
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Semua route di bawah butuh login
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/reports/export/pdf', 
    [App\Http\Controllers\ReportController::class,
     'exportPdf'])->name('reports.export.pdf');
    Route::get('/reports/export/excel', 
    [App\Http\Controllers\ReportController::class,
     'exportExcel'])->name('reports.export.excel');
     
    // Hanya Admin — Master Data
    Route::middleware('role:Super Admin')->group(function () {
        Route::resource('levels', LevelController::class)->except(['show']);
        Route::resource('customers', CustomerController::class)->except(['show']);
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('type-of-services', TypeOfServiceController::class)->except(['show']);
    });

    // Admin dan Operator — Transaksi
    Route::middleware('role:Super Admin,Operator')->group(function () {
        Route::resource('orders', TransOrderController::class)->except(['edit', 'update', 'destroy']);
        Route::resource('pickups', TransLaundryPickupController::class)->except(['show', 'edit', 'update', 'destroy']);
    });

    // Admin dan Pimpinan — Laporan
    Route::middleware('role:Super Admin,Pimpinan')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});