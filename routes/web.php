<?php

use App\Models\History;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\HistoryController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/items', [ItemController::class, 'index']);
Route::post('/items', [ItemController::class, 'create']);
Route::get('/items/{item}/edit', [ItemController::class, 'edit']);
Route::put('/items/{item}/edit', [ItemController::class, 'update']);
Route::delete('/items/{item}', [ItemController::class, 'destroy']); 
Route::get('/items/search', [ItemController::class, 'search']);

Route::get('/items/{item}/issue', [IssueItemController::class, 'edit']);
Route::post('/issue/items', [IssueItemController::class, 'create']);
Route::get('/issue/items', [IssueItemController::class, 'index']);
Route::get('/items/{issue}/list', [IssueItemController::class, 'show']);
Route::put('/items/{issue}/lists', [IssueItemController::class, 'update']);
Route::get('/issue/search', [IssueItemController::class, 'search']);

Route::get('/items/{issue}/return', [ReturnController::class, 'showReturn']);

Route::post('/items/return', [HistoryController::class, 'create']);
Route::get('/items/history', [HistoryController::class, 'index']);
Route::delete('/return/{data}', [HistoryController::class, 'destroy']);;
Route::get('/items/search', [HistoryController::class, 'search']);

Route::get('/users', [UserController::class, 'index']);


Route::get('{view}', ApplicationController::class)->where('view', '(.*)');