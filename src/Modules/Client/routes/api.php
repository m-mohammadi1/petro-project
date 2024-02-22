<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Client\App\Http\Controllers\CreateClientController;

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

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {

    // a route to create the client
    Route::post("client", CreateClientController::class)->name("client.create");

});
