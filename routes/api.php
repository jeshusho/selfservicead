<?php

use App\Http\Controllers\AduserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SelfserviceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('adusers', [AduserController::class, 'store'])->name('adusers');
Route::middleware('auth:sanctum')->get('sendnotifications', [NotificationController::class, 'send'])->name('sendnotifications');
Route::get('test', [NotificationController::class, 'test'])->name('test');

Route::middleware('auth:sanctum')->get('selfservice-list', [SelfserviceController::class, 'list'])->name('selfservice-list');
Route::middleware('auth:sanctum')->put('selfservice/{data}', [SelfserviceController::class, 'update'])->name('api-selfservice.put');