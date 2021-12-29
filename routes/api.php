<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

 Route::apiResources(['user' => App\Http\Controllers\API\UserController::class]);
    Route::apiResources(['arena' => App\Http\Controllers\API\ArenaController::class]);
    Route::apiResources(['import' => App\Http\Controllers\API\ImportController::class]);
    Route::apiResources(['bankaccount' => App\Http\Controllers\API\BankDetailsController::class]);
    Route::apiResources(['employees' => App\Http\Controllers\API\EmployeeController::class]);

    
    Route::get('profile', [App\Http\Controllers\API\UserController::class, 'profile'])->name('profile');
    Route::put('profile', [App\Http\Controllers\API\UserController::class, 'updateProfile'])->name('updateProfile');
    Route::get('arenaId', [App\Http\Controllers\API\BankDetailsController::class, 'show_arena'])->name('arenaId');
    Route::get('filterBank/{id}', [App\Http\Controllers\API\BankDetailsController::class, 'FilterBank']);
    Route::get('importwithstatus', [App\Http\Controllers\API\ImportController::class, 'withstatus']);
    Route::get('depositeandreflenish', [App\Http\Controllers\API\ImportController::class, 'depositedata']);
    Route::get('count', [App\Http\Controllers\API\ImportController::class, 'countdata']);
    Route::get('updateBank/{id}/{bank_id}', [App\Http\Controllers\API\ImportController::class, 'updatebankaccount']);
    Route::get('selectedbank/{id}', [App\Http\Controllers\API\ImportController::class, 'bankaccountfilter']);
    Route::put('arenaStatus/{id}', [App\Http\Controllers\API\ImportController::class, 'arenastatus']);
    Route::get('convertToExcel/{data}', [App\Http\Controllers\API\ImportController::class, 'ConvertToExcel']);
    Route::get('validate/{password}', [App\Http\Controllers\API\UserController::class, 'validate_user']);
    Route::get('selected/{id}/{group}/{new}', [App\Http\Controllers\API\EmployeeController::class, 'selectedbyUser']);
    Route::get('counts', [App\Http\Controllers\API\EmployeeController::class, 'countEmployee']);
    Route::get('artisanCall', [App\Http\Controllers\API\importController::class, 'artisan']);