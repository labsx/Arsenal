<?php

use App\Models\History;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IssueItemController;
use App\Http\Controllers\ApplicationController;

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
Route::get('/', [LoginController::class, 'index']);

Route::middleware('auth')->group(function(){
    Route::get('/items', [ItemController::class, 'index']);
    Route::post('/items', [ItemController::class, 'create']);
    Route::get('/items/{item}/edit', [ItemController::class, 'edit']);
    Route::put('/items/{item}/edit', [ItemController::class, 'update']);
    Route::delete('/items/{item}', [ItemController::class, 'destroy']); 
    Route::delete('/items', [ItemController::class, 'bulkDelete']); 
    Route::get('/items/list/search', [ItemController::class, 'search']);

    Route::get('/items/{item}/issue', [IssueItemController::class, 'edit']);
    Route::post('/issue/items', [IssueItemController::class, 'create']);
    Route::get('/issue/items', [IssueItemController::class, 'index']);
    Route::get('/items/{issue}/list', [IssueItemController::class, 'show']);
    Route::put('/items/{issue}/lists', [IssueItemController::class, 'update']);
    Route::get('/issue/search', [IssueItemController::class, 'search']);

    Route::get('/items/{issue}/return', [ReturnController::class, 'showReturn']);

    Route::post('/items/return', [HistoryController::class, 'create']);
    Route::get('/items/history', [HistoryController::class, 'itemHistory']);
    Route::get('/items/search', [HistoryController::class, 'search']);
    Route::delete('/items/{item}/delete', [HistoryController::class, 'destroyHistory']);

    Route::post('/users', [UserController::class, 'create']);
    Route::get('/users/search', [UserController::class, 'searchUser']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']); 
    Route::get('/users', [UserController::class, 'index']);

    Route::get('/users/profile', [ProfileController::class, 'profile']);
    Route::put('/users/profile', [ProfileController::class, 'update']); 
    Route::post('/users/profile', [ProfileController::class, 'updatePassword']); 
    Route::post('/users/profile/picture', [ProfileController::class, 'upload']); 

    Route::get('/dashboard', [DashboardController::class, 'itemsCount']);
    Route::get('/dashboard/users', [DashboardController::class, 'usersCount']);

    Route::get('{view}', ApplicationController::class)->where('view', '(.*)'); 
});



