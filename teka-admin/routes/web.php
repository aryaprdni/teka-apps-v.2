<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/login', [\App\Http\Controllers\AdminController::class, 'viewLogin']);
Route::post('/login', [\App\Http\Controllers\AdminController::class, 'login']);

Route::middleware(\App\Http\Middleware\AdminAuthMiddleware::class)->group(function () {
    Route::get('/', [\App\Http\Controllers\Controller::class, 'index']);

    Route::get('/avatar', [\App\Http\Controllers\AvatarController::class, 'index']);
    Route::get('/avatar/create', [\App\Http\Controllers\AvatarController::class, 'viewCreateAvatar']);
    Route::post('/avatar/create', [\App\Http\Controllers\AvatarController::class, 'adminCreateAvatar']);
    Route::delete('/avatar/delete/{id}', [\App\Http\Controllers\AvatarController::class, 'adminDeletevatar']);
    Route::get('/avatar/edit/{id}', [\App\Http\Controllers\AvatarController::class, 'viewEditAvatar']);
    Route::put('/avatar/edit/{id}', [\App\Http\Controllers\AvatarController::class, 'adminUpdateAvatar']);

    Route::get('/quiz', [\App\Http\Controllers\QuizController::class, 'index']);
    Route::get('/quiz/create', [\App\Http\Controllers\QuizController::class, 'viewCreateQuiz']);
    Route::post('/quiz/create', [\App\Http\Controllers\QuizController::class, 'adminCreateQuiz']);
    Route::delete('/quiz/delete/{id}', [\App\Http\Controllers\QuizController::class, 'adminDeleteQuiz']);
    Route::get('/quiz/edit/{id}', [\App\Http\Controllers\QuizController::class, 'viewEditQuiz']);
    Route::put('/quiz/edit/{id}', [\App\Http\Controllers\QuizController::class, 'adminUpdateQuiz']);

    Route::get('/diamond', [\App\Http\Controllers\DiamondController::class, 'index']);
    Route::get('/diamond/create', [\App\Http\Controllers\DiamondController::class, 'viewCreateDiamond']);
    Route::post('/diamond/create', [\App\Http\Controllers\DiamondController::class, 'adminCreateDiamond']);
    Route::delete('/diamond/delete/{id}', [\App\Http\Controllers\DiamondController::class, 'adminDeleteDiamond']);
    Route::get('/diamond/edit/{id}', [\App\Http\Controllers\DiamondController::class, 'viewEditDiamond']);
    Route::put('/diamond/edit/{id}', [\App\Http\Controllers\DiamondController::class, 'adminUpdateDiamond']);
    
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::get('/user/create', [\App\Http\Controllers\UserController::class, 'viewCreateUser']);
    Route::post('/user/create', [\App\Http\Controllers\UserController::class, 'adminCreateUser']);
    Route::delete('/user/delete/{id}', [\App\Http\Controllers\UserController::class, 'adminDeleteUser']);
    Route::get('/user/edit/{id}', [\App\Http\Controllers\UserController::class, 'viewEditUser']);
    Route::put('/user/edit/{id}', [\App\Http\Controllers\UserController::class, 'adminUpdateUser']);


    Route::get('/payment', function () {
        return view('pages.payment.payment');
    });

    Route::post('/logout', [\App\Http\Controllers\AdminController::class, 'logout']);
});