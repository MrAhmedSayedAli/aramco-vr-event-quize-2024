<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
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
/*
Route::get('test', function () {

    $x = ((5 * 900000) - 600000) / 1000;
    dd($x);
    //return view('welcome');
});
*/
/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

//Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');


//Route::get('/test', function () {return view('test');})->name('test');

Route::get('/', function () {return redirect()->route('player.register');})->name('index');

Route::get('/player/check-in', [PlayerController::class, 'login'])->name('player.login');
Route::post('/player/check-in', [PlayerController::class, 'doLogin']);


Route::get('/player/forget-id', [PlayerController::class, 'playerForgetID'])->name('player.forget');
Route::post('/player/forget-id', [PlayerController::class, 'playerDoForgetID']);

Route::get('/player/register', [PlayerController::class, 'playerRegister'])->name('player.register');
Route::post('/player/register', [PlayerController::class, 'playerDoRegister']);

Route::get('/player/leaderboard', [PlayerController::class, 'playerLeaderboard'])->name('player.leaderboard');
Route::post('/player/leaderboard', [PlayerController::class, 'playerLeaderboardAjax'])->name('player.leaderboard_ajax');

Route::get('/player/checkin-board', [PlayerController::class, 'playerCheckInBoard'])->name('player.checkin');
Route::post('/player/checkin-board', [PlayerController::class, 'playerCheckInBoardAjax'])->name('player.checkin_ajax');


Route::get('quiz/{uuid}', [QuizController::class, 'index'])->name('quiz.index');
Route::get('quiz/{uuid}/{id}', [QuizController::class, 'step'])->name('quiz.step');
Route::post('quiz/{uuid}/{id}', [QuizController::class, 'stepSave']);


Route::get('template', [QuizController::class, 'templateLoader'])->name('template');
Route::get('template/{id}', [QuizController::class, 'templateLoaderId'])->name('template.id');


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/dashboard/test', [\App\Http\Controllers\TestController::class, 'test'])->name('dashboard.test');
    Route::get('/dashboard/q', [\App\Http\Controllers\DashboardController::class, 'QData'])->name('dashboard.q');

    Route::get('/dashboard/leader', [DashboardController::class, 'leader'])->name('dashboard.leader');
    Route::post('/dashboard/leader_ajax', [DashboardController::class, 'leaderAjax'])->name('dashboard.leader_ajax');

    Route::get('/dashboard/players', [DashboardController::class, 'players'])->name('dashboard.players');
    Route::post('/dashboard/players_ajax', [DashboardController::class, 'playersAjax'])->name('dashboard.players_ajax');

    Route::get('/dashboard/players_xlsx', [PlayerController::class, 'export'])->name('dashboard.players.export');

    Route::delete('/dashboard/administrator/delete_data', [DashboardController::class, 'deleteAll'])->name('dashboard.administrator.delete_all');


    Route::get('/dashboard/players/register', [PlayerController::class, 'register'])->name('dashboard.player.register');
    Route::post('/dashboard/players/register', [PlayerController::class, 'doRegister']);

    Route::get('/dashboard/player/check-in', [DashboardController::class, 'login'])->name('dashboard.login');
    Route::post('/dashboard/player/check-in', [DashboardController::class, 'doLogin']);

    //Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    //Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');



    Route::get('dashboard/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('dashboard/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
