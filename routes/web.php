<?php

use App\Mail\EmailSoa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });
// route::get('/email',function(){
//     $data["email"] = "fsiapco@gmail.com";
//     $data["type"] = "Statement of Account";
//     $data["date"] = "March 23, 2022";
//     $data["subject"] = "KIOSK SALES REPORT FOR MARCH 23, 2022";
//     $files = [
//         public_path('zip/test.rar'),
//     ];
//     Mail::send('email.emailsoa', $data, function($message)use($data, $files) {
//         $message->to($data["email"])
//                 ->subject($data["subject"]);

//         foreach ($files as $file){
//             $message->attach($file);
//         }

//     });

//     dd('Mail sent successfully');

// });
// Route::get('/register', function () {
//   return view('register');
// });

// Auth::routes();
Route::middleware('preventBackHistory')->group(function () {
  Auth::routes([
    'register' => true, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
  ]);
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('{path}', [App\Http\Controllers\HomeController::class, 'index'])->where('path', '([A-z]+)?');
Route::get('backup', [App\Http\Controllers\API\UserController::class, 'artisancall']);


});

