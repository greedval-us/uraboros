<?php

use App\Http\Controllers\TelegramAnalyticsController;
use App\Http\Controllers\TelegramReportController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('telegram', TelegramAnalyticsController::class)
    ->middleware(['auth', 'verified'])
    ->name('telegram');

Route::post('telegram/reports/start', [TelegramReportController::class, 'start'])
    ->middleware(['auth', 'verified'])
    ->name('telegram.reports.start');

Route::get('telegram/reports/status/{taskId}', [TelegramReportController::class, 'status'])
    ->middleware(['auth', 'verified'])
    ->name('telegram.reports.status');

Route::get('telegram/reports/download/{taskId}', [TelegramReportController::class, 'download'])
    ->middleware(['auth', 'verified'])
    ->name('telegram.reports.download');

require __DIR__.'/settings.php';
