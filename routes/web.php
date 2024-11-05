<?php

use App\Http\Controllers\AduserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SelfserviceController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [MessageController::class, 'index'])
                ->name('dashboard');
    Route::get('/messages/filter/{message_date_ini?}/{message_date_end?}', [MessageController::class, 'filter'])
                ->name('messages.filter');
    Route::get('/messages-export-excel/{message_date_ini?}/{message_date_end?}', [MessageController::class, 'export_excel'])
                ->name('messages.export-excel');
    Route::get('/adusers', [AduserController::class, 'index'])
                ->name('adusers.index');
    Route::get('/adusers-export-excel', [AduserController::class, 'export_excel'])
                ->name('adusers.export-excel');
    Route::get('/settings', [SettingController::class, 'index'])
                ->name('settings.index');
    Route::resource('notifications', NotificationController::class)
                ->except(['create', 'show', 'edit']);
    Route::resource('schedules', ScheduleController::class)
                ->except(['create', 'show', 'edit']);
});

Route::get('/selfservice', [SelfserviceController::class, 'index'])->name('selfservice');