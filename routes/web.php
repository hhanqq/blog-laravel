<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


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

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('post/{id}', [PostController::class, 'show'])->name('post.show');


Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('add-post', [PostController::class, 'create'])->name('add-post');
    Route::post('add-post', [PostController::class, 'store'])->name('post.store');
});


Route::middleware('guest')->group(function () {
    Route::get('register', [UserController::class, 'create'])->name('register');
    Route::post('register', [UserController::class, 'store'])->name('user.store');
    Route::get('login', [UserController::class, 'login'])->name('login');
    Route::post('login', [UserController::class, 'loginAuth'])->name('login.auth');

    Route::get('forgot-password', function(){
        return view('user.forgot-password');
    })->name('password.request');

    Route::post('forgot-password', [UserController::class, 'forgotPasswordStore'])
    ->name('password.email')
    ->middleware('throttle:3,1');

    Route::get('reset-password/{token}', function (string $token) {
        return view('user.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset-password', [UserController::class, 'resetPasswordUpdate'])->name('password.update');
});


Route::middleware('auth')->group(function () {
    Route::get('verify-email', function () {
        return view('user.verify-email');
    })->name('verification.notice');

    Route::get('email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('dashboard');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:3,1')->name('verification.send');

    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});