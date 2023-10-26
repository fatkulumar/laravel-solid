<?php

use App\Http\Controllers\Api\SuperAdmin\User\UserSuperAdminController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/users', [UserSuperAdminController::class, 'users']);
    Route::post('/users/update', [UserSuperAdminController::class, 'updateUser']);

});
