<?php

use App\Http\Controllers\GitHubController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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


Route::get('/auth/github', [GitHubController::class, 'redirectToProvider']);
Route::get('/auth/github/callback', [GitHubController::class, 'handleProviderCallback']);
Route::get('/profile', [GitHubController::class, 'profile'])->name('profile');



