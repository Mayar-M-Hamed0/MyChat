<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendshipController;

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


Route::middleware('auth:sanctum')->group(function () {
    Route::post('friends/request', [FriendshipController::class, 'sendRequest']);
    Route::post('friends/accept/{id}', [FriendshipController::class, 'acceptRequest']);
    Route::post('friends/decline/{id}', [FriendshipController::class, 'declineRequest']);
    Route::delete('friends/remove/{id}', [FriendshipController::class, 'removeFriend']);
    Route::get('friends', [FriendshipController::class, 'friends']);
    Route::get('friends/requests', [FriendshipController::class, 'friendRequests']);
});
