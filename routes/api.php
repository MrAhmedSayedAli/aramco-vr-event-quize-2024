<?php

use App\Http\Controllers\Api\QuizApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/',function(){
    return response()->json([
        ':D'
    ]);
});

Route::get('player/login', [QuizApiController::class, 'newQuiz'])->name('player_login');
Route::get('quiz/check', [QuizApiController::class, 'checkQuiz'])->name('quiz_check');
Route::get('quiz/submit', [QuizApiController::class, 'submitQuizAnswer'])->name('quiz_submit');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
