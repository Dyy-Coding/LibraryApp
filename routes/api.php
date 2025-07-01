<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Author\AuthorApiController;
use App\Http\Controllers\Api\Book\BookApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group. 
| All routes here are prefixed with /api.
| Now versioned with /api/v1
|
*/

// Authenticated user info route (optional)
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('authors')->group(function () {
    Route::get('/', [AuthorApiController::class, 'index']);
    Route::post('/', [AuthorApiController::class, 'store']);
    Route::get('/{id}', [AuthorApiController::class, 'show'])->where([0-9]);
    Route::put('/{id}', [AuthorApiController::class, 'update'])->where([0-9]);
    Route::delete('/{id}', [AuthorApiController::class, 'destroy'])->where([0-9]);
});
Route::prefix('books')->group(function () {
    Route::get('/', [BookApiController::class, 'index']);
    Route::post('/', [BookApiController::class, 'store']);
    Route::get('/{id}', [BookApiController::class, 'show'])->where([0-9]);
    Route::put('/{id}', [BookApiController::class, 'update'])->where([0-9]);
    Route::delete('/{id}', [BookApiController::class, 'destroy'])->where([0-9]);
});

