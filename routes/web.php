<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomauthController; 
use App\Http\Controllers\ForgotPasswordController; 
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MailController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::get('login',[CustomauthController::class,"index"])->name('login');
Route::get('register',[CustomauthController::class,"register_view"])->name('register');
Route::post('adduser',[CustomauthController::class,"adduser"])->name('adduser');
Route::post('registeruser',[CustomauthController::class,"getuser"])->name('getuser');
Route::get('signout', [CustomauthController::class,"logout"])->name('signout');
Route::get('chat',[CustomauthController::class,"chat"])->name('chat');


Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


Route::get('dashboard', [CustomauthController::class, 'dashboard'])->middleware(['auth', 'verify_email']); 
Route::get('account/verify/{token}', [CustomauthController::class, 'verifyAccount'])->name('auth.user.verify');
Route::get('sendTokenAgain/{id}', [CustomauthController::class, 'sendTokenAgain'])->name('sendTokenAgain');


Route::post('sendReequest',[ChatController::class,'sendReequest']);
Route::post('acceptReequest',[ChatController::class,'acceptReequest']);
Route::get('chatgroup/{id}',[ChatController::class,'chatgroup'])->name('letschat');
Route::post('letscahatnew',[ChatController::class,'chatgroupletscahatnew'])->name('letscahatnew');











