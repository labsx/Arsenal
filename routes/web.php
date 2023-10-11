<?php

use App\Models\History;
use App\Models\FieldGroup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NavBarController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IssueItemController;
use App\Http\Controllers\FieldGroupController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ItemAttributesController;

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

Route::middleware('auth')->group(function () {
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category', [CategoryController::class, 'search']);
    Route::post('/category', [CategoryController::class, 'create']);
    Route::put('/category/{category}', [CategoryController::class, 'update']);
    Route::delete('/category/{category}', [CategoryController::class, 'destroy']);
    Route::get('/category/{category}/show', [CategoryController::class, 'show']);
    Route::get('/category-data', [CategoryController::class, 'listName']);

    Route::get('/field-group', [FieldGroupController::class, 'index']);
    Route::post('/field-group', [FieldGroupController::class, 'create']);
    Route::put('/field-group/{field}', [FieldGroupController::class, 'update']);
    Route::delete('/field-group/{field}', [FieldGroupController::class, 'destroy']);
    Route::get('/field-group', [FieldGroupController::class, 'search']);
    Route::get('/field-group/{field}', [FieldGroupController::class, 'show']);
    Route::get('/field-group/data', [FieldGroupController::class, 'getFields']);
    Route::get('/field-group/name', [FieldGroupController::class, 'getName']);
    Route::get('/field-groups/{id}', [FieldGroupController::class, 'getFieldGroupName']);
    Route::get('/field-groups/{id}/fields', [FieldGroupController::class, 'getFieldsByFieldGroupId']);

    Route::get('/fields/{id}/show', [FieldController::class, 'show']);
    Route::post('/fields', [FieldController::class, 'store']);
    Route::get('/fields', [FieldController::class, 'index']);
    Route::get('/fields/search', [FieldController::class, 'search']);
    Route::delete('/fields/{field}', [FieldController::class, 'destroy']);
    Route::get('/fields/{field}', [FieldController::class, 'editShow']);
    Route::put('/fields/{field}', [FieldController::class, 'update']);
    Route::get('/fields', [FieldController::class, 'filterFields']);

    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/{item}/show', [ItemController::class, 'getItems']);
    Route::put('/items/{item}', [ItemController::class, 'update']);
    Route::get('items/{item}/attributes', [ItemController::class, 'getAttributes']);
    Route::post('/item-attributes', [ItemAttributesController::class, 'store']);
    Route::get('/items', [ItemController::class, 'search']);
    Route::delete('/items/{item}', [ItemController::class, 'destroy']);
    Route::get('/items/{id}/filter-item', [ItemController::class, 'show']);

    Route::get('/parent', [ParentController::class, 'index']);
    Route::get('/parent-data', [ParentController::class, 'getData']);
    Route::post('/parent', [ParentController::class, 'store']);
    Route::get('/parent', [ParentController::class, 'search']);
    Route::get('/parent/{id}/show', [ParentController::class, 'showData']);
    Route::delete('/parent/{parent}', [ParentController::class, 'destroy']);
    Route::get('/parent/{parent}', [ParentController::class, 'show']);
    Route::put('/parent/{parent}', [ParentController::class, 'update']);

    Route::get('/items/{item}/issue', [IssueItemController::class, 'edit']);
    Route::post('/issue/items', [IssueItemController::class, 'create']);
    Route::get('/issue', [IssueItemController::class, 'index']);
    Route::get('/issue', [IssueItemController::class, 'search']);
    Route::get('/issues/{issue}', [IssueItemController::class, 'showUser']);
    Route::put('/issues/{issue}', [IssueItemController::class, 'update']);

    Route::get('/items/{issue}/return', [ReturnController::class, 'showReturn']);
    Route::post('/items/return', [ReturnController::class, 'return']);

    Route::get('/history', [HistoryController::class, 'index']);
    Route::get('/history', [HistoryController::class, 'search']);

    Route::post('/users', [UserController::class, 'create']);
    Route::get('/users/search', [UserController::class, 'searchUser']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/profile', [ProfileController::class, 'profile']);
    Route::put('/users/profile', [ProfileController::class, 'update']);
    Route::post('/users/profile', [ProfileController::class, 'updatePassword']);
    Route::post('/users/profile/picture', [ProfileController::class, 'upload']);

    Route::prefix('dashboard')->group(function () {
        Route::get('category', [DashboardController::class, 'categoryCount']);
        Route::get('users', [DashboardController::class, 'usersCount']);
        Route::get('fields', [DashboardController::class, 'fieldsCount']);
        Route::get('items', [DashboardController::class, 'itemsCount']);
        Route::get('history', [DashboardController::class, 'historyCount']);
        Route::get('notes', [DashboardController::class, 'countNotes']);
        Route::get('progress', [DashboardController::class, 'progressBar']);
        Route::get('users/data', [DashboardController::class, 'usersGet']);
    });

    Route::get('/notes/data', [NavBarController::class, 'index']);
    Route::get('/notification', [NavBarController::class, 'notification']);
    Route::delete('/notification/{id}', [NavBarController::class, 'deleteNotification']);
    Route::post('/notes', [NavBarController::class, 'notes']);
    Route::get('/user/{id}', [NavBarController::class, 'getUser']);
    Route::delete('/notes/{note}', [NavBarController::class, 'destroy']);

    Route::get('{view}', ApplicationController::class)->where('view', '(.*)');
});
