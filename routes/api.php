<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\GroupController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'v1'], function () {
    Route::post("register", [AuthController::class, 'register']);
    Route::post("login", [AuthController::class, "login"]);

    Route::group([
        "middleware" => ["auth:api"]
    ], function () {
        Route::get("profile", [AuthController::class, "profile"]);
        Route::put("profile", [AuthController::class, "update"]);
        Route::put("profile/update-profile", [AuthController::class, "updateProfilePicture"]);
        Route::get("logout", [AuthController::class, "logout"]);
    });
    Route::resource('contacts', ContactController::class);
    Route::post('update-profile-picture', [AuthController::class, 'updateProfilePicture']);

    Route::resource('groups', GroupController::class);

    Route::post('/groups/{groupId}/add-contact/{contactId}',  [GroupController::class, "addContact"]);
    Route::delete('/groups/{groupId}/remove-contact/{contactId}', [GroupController::class, "removeContact"]);
});
