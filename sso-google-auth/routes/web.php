<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SSO\AuthProviderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login-other-method', function () {
    return view('auth.login-other-method');
})->name('login-other-method');

Route::get('/auth/{provider}', [AuthProviderController::class, 'redirectToProvider'])->name('auth.provider.redirect');
Route::get('/auth/{provider}/callback', [AuthProviderController::class, 'handleProviderCallback'])->name('auth.provider.callback');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
