<?php

use App\Http\Controllers\API\AndonController;
use App\Http\Controllers\API\AssignWOController;
use App\Http\Controllers\EmployeeController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('assign')->group(function() {
    Route::get('', [AssignWOController::class, 'index']); // jadi muncul api/assign
    Route::get('/{id}', [AssignWOController::class, 'show']); // jadi muncul api/assign/id
});

Route::prefix('employee')->group(function() {
    Route::get('/{id}', [EmployeeController::class, 'show']); // jadi muncul api/employee/id
});
Route::prefix('andon')->group(function() {
    Route::get('', [AndonController::class, 'index']); // jadi muncul api/andon/id
    Route::get('/{workcenter}', [AndonController::class, 'sortByWorkcenter']); // jadi muncul api/andon/sort-by-workcenter?workcenter=56
});


// Route::get('', [ProductController::class, 'index']); // jadi muncul api/product
//     Route::get('/{id}', [ProductController::class, 'show']); // jadi muncul api/product/id
//     Route::post('', [ProductController::class, 'store']);
//     Route::put('/{id}', [ProductController::class, 'update']);
//     Route::delete('/{id}', [ProductController::class, 'destroy']);
