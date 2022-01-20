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
    Route::apiResources(['contactnumbers' => App\Http\Controllers\API\ContactController::class]);
    Route::apiResources(['emails' => App\Http\Controllers\API\EmailController::class]);
    Route::apiResources(['teams' => App\Http\Controllers\API\TeamController::class]);


    Route::get('profile', [App\Http\Controllers\API\UserController::class, 'profile'])->name('profile');
    Route::put('profile', [App\Http\Controllers\API\UserController::class, 'updateProfile'])->name('updateProfile');
    Route::get('arenaId', [App\Http\Controllers\API\BankDetailsController::class, 'show_arena'])->name('arenaId');
    Route::get('filterBank/{id}', [App\Http\Controllers\API\BankDetailsController::class, 'FilterBank']);
    Route::get('Companybanks', [App\Http\Controllers\API\BankDetailsController::class, 'Companybank']);
    Route::get('importwithstatus', [App\Http\Controllers\API\ImportController::class, 'withstatus']);
    Route::get('depositeandreflenish', [App\Http\Controllers\API\ImportController::class, 'depositedata']);
    Route::get('count', [App\Http\Controllers\API\ImportController::class, 'countdata']);
    Route::get('updateBank/{id}/{bank_id}', [App\Http\Controllers\API\ImportController::class, 'updatebankaccount']);
    Route::get('selectedbank/{id}', [App\Http\Controllers\API\ImportController::class, 'bankaccountfilter']);
    // Route::put('arenaStatus/{id}', [App\Http\Controllers\API\ImportController::class, 'arenastatus']);
    Route::put('arenaStatus', [App\Http\Controllers\API\ImportController::class, 'arenastatus']);
    Route::put('updateBankSelection/{id}', [App\Http\Controllers\API\ArenaController::class, 'updateBankSelection']);
    Route::get('getEmails/{areaCode}', [App\Http\Controllers\API\ArenaController::class, 'getEmails']);
    Route::get('getContacts/{areaCode}', [App\Http\Controllers\API\ArenaController::class, 'getContacts']);
    Route::get('emailDelete/{id}', [App\Http\Controllers\API\ArenaController::class, 'deleteEmail']);
    Route::delete('deleteContact/{id}', [App\Http\Controllers\API\ArenaController::class, 'deleteContact']);
    
    Route::get('arenaSelectedBank/{id}', [App\Http\Controllers\API\BankDetailsController::class, 'arenaSelectedBank']);
    Route::get('convertToExcel/{group}/{data}', [App\Http\Controllers\API\ImportController::class, 'ConvertToExcel']);
    Route::get('validate/{password}', [App\Http\Controllers\API\UserController::class, 'validate_user']);
    Route::put('selected/{id}', [App\Http\Controllers\API\EmployeeController::class, 'selectedbyUser']);
    Route::post('saveposition', [App\Http\Controllers\API\EmployeeController::class, 'savepostionNow']);
    Route::get('getposition', [App\Http\Controllers\API\EmployeeController::class, 'getpostionNow']);
    Route::get('deletePosition/{id}', [App\Http\Controllers\API\EmployeeController::class, 'deletepostionNow']);
    Route::put('updateposition/{id}', [App\Http\Controllers\API\EmployeeController::class, 'updatepostionNowwith']);

    Route::post('importArena', [App\Http\Controllers\API\ArenaController::class, 'importArena']);
    Route::post('bankStore', [App\Http\Controllers\API\BankDetailsController::class, 'bankStore']);


    Route::get('getArenaTeam/{team}', [App\Http\Controllers\API\ArenaController::class, 'getArenaTeam']);
    Route::put('updateArenaTeam/{areaCode}', [App\Http\Controllers\API\ArenaController::class, 'updateArenaTeam']);






   