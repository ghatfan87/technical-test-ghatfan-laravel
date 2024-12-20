<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistItemController;
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

// Route::prefix('v1')->group(function (){
//     Route::post('/register',[AuthController::class,'register']);
//     Route::post('/login',[AuthController::class,'login']);
// });

// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('checklists', ChecklistController::class);

//     //checklist item
//     Route::prefix('checklists/{checklist}')->group(function () {
//         Route::get('/items', [ChecklistItemController::class, 'index']);
//         Route::post('/items', [ChecklistItemController::class, 'store']);
//         Route::get('/items/{item}', [ChecklistItemController::class, 'show']);
//         Route::put('/items/{item}', [ChecklistItemController::class, 'update']);
//         Route::patch('/items/{item}/status', [ChecklistItemController::class, 'updateStatus']);
//         Route::delete('/items/{item}', [ChecklistItemController::class, 'destroy']);
//     });
// });
