<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Client\App\Http\Controllers\CreateClientController;
use Modules\Client\App\Http\Controllers\CreateOrderController;

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

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.client.')->group(function () {
    Route::post("client", CreateClientController::class)->name("client.create");
    Route::post("order", CreateOrderController::class)->name("order.create");
});
