<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// --------------------------------------------------------------------------
// JWT AUTH ROUTES (Public Access)
// These routes do NOT require a token to access.
// --------------------------------------------------------------------------
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


// --------------------------------------------------------------------------
// JWT AUTH ROUTES (Protected Access)
// All routes in this group require a valid JWT via the 'auth:api' middleware.
// --------------------------------------------------------------------------
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);

    // Your other API endpoints...
    Route::get('protected-resource', function () {
        return response()->json(['message' => 'This is a secured resource.']);
    });
});


// --------------------------------------------------------------------------
// SANCTUM ROUTE (If you intend to use Sanctum for SPAs/Mobile)
// --------------------------------------------------------------------------
// ⚠️ CONFLICT WARNING: If you use JWT for your API, you should generally
// remove or separate this Sanctum route, as you are mixing two authentication systems.
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});