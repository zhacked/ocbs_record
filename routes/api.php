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


Route::get('profile', [App\Http\Controllers\API\UserController::class, 'profile'])->name('profile');
Route::put('profile', [App\Http\Controllers\API\UserController::class, 'updateProfile'])->name('updateProfile');
Route::get('findUser', [App\Http\Controllers\API\UserController::class, 'search']);
Route::get('arenaId', [App\Http\Controllers\API\BankDetailsController::class, 'show_arena'])->name('arenaId');


Route::get('updateBank/{id}/{bank_id}', [App\Http\Controllers\API\ImportController::class, 'updatebankaccount']);
Route::get('bankfilter/{id}', [App\Http\Controllers\API\ImportController::class, 'bankaccountfilter']);
Route::get('savePrimaryBank/{id}', [App\Http\Controllers\API\ImportController::class, 'SavePrimaryBank']);

