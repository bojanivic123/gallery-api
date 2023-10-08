<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource("/galleries", GalleryController::class);

Route::controller(AuthController::class)->group(function () {
    Route::post("register", "register");
    Route::post("login", "login");
    Route::post("logout", "logout");
    Route::post("refresh", "refresh");
    Route::get("users", "getUsers");
    Route::get("users/{userId}/galleries", "getUserGalleries");
    Route::get("users/{id}", "getUser");
});

Route::post("/galleries/{id}/comments", [CommentController::class, "store"]);
Route::delete("/comments/{id}", [CommentController::class, "destroy"]);

