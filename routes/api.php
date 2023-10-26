<?php

use App\Http\Controllers\Api\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/test', [TestController::class, 'index']);
    Route::get('/test/{id}', [TestController::class, 'show']);
    Route::post('/test', [TestController::class, 'store']);
    Route::post('/update/{id}', [TestController::class, 'update']);
    Route::delete('delete/{id}', [TestController::class, 'delete']);
    Route::post('destroy', [TestController::class, 'destroy']);

});


