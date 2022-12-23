<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;

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

// Route::get('/get-suggestions', [App\Http\Controllers\HomeController::class, 'getSuggestions']);

Route::post('get-more-suggestions', [App\Http\Controllers\HomeController::class, 'getSuggestions']);
Route::post('get-more-requests', [App\Http\Controllers\HomeController::class, 'getRequests']);
Route::post('get-more-connections', [App\Http\Controllers\HomeController::class, 'getConnections']);

Route::resource('requests', RequestController::class);

Route::post('remove-connection', [App\Http\Controllers\HomeController::class, 'removeConnection']);