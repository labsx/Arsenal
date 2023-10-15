<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\FieldGroupController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\IssueItemController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NavBarController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index']);
Route::middleware('auth')->group(function () {
    Route::resource('category', CategoryController::class)
        ->only(['index', 'store', 'destroy', 'update']);
    Route::get('/category', [CategoryController::class, 'search']);
    Route::get('/category/{category}/show', [CategoryController::class, 'show']);
    Route::get('/category-data/{category}', [CategoryController::class, 'listName']);
    Route::get('/category-data', [CategoryController::class, 'categoryData']);

    Route::resource('field-group', FieldGroupController::class)->only([
        'index', 'store', 'destroy', 'update', 'show',
    ]);
    Route::get('/field-group', [FieldGroupController::class, 'search']);
    Route::get('/field-group/data', [FieldGroupController::class, 'getFields']);
    Route::get('/field-groups/{id}', [FieldGroupController::class, 'getFieldGroupName']);
    Route::get('/field-groups/{id}/fields', [FieldGroupController::class, 'getFieldsByFieldGroupId']);

    Route::resource('fields', FieldController::class)->only([
        'index', 'store', 'destroy', 'update',
    ]);
    Route::get('/fields/{id}/show', [FieldController::class, 'show']);
    Route::get('/fields/search', [FieldController::class, 'search']);
    Route::get('/fields/{field}', [FieldController::class, 'editShow']);
    Route::get('/fields', [FieldController::class, 'filterFields']);
    Route::get('/fields-data/{field}', [FieldController::class, 'getFieldsId']);
    Route::get('/fields', [FieldController::class, 'getFieldsDetails']);

    Route::resource('items', ItemController::class)->only([
        'index', 'store', 'destroy', 'update',
    ]);
    Route::get('/items/{item}/show', [ItemController::class, 'getItems']);
    Route::get('items/{item}/attributes', [ItemController::class, 'getAttributes']);
    Route::get('/items', [ItemController::class, 'search']);
    Route::get('/items/{id}/filter-item', [ItemController::class, 'show']);

    Route::resource('parent', ParentController::class)->only([
        'index', 'store', 'destroy', 'update',
    ]);
    Route::get('/parent/sub', [ParentController::class, 'getSubCategroy']);
    Route::get('/parent', [ParentController::class, 'search']);
    Route::get('/parent/{id}/show', [ParentController::class, 'showData']);
    Route::get('/parent/{parent}', [ParentController::class, 'show']);
    Route::put('/parent/{parent}', [ParentController::class, 'update']);

    Route::resource('employee', EmployeeController::class)->only([
        'index', 'store', 'destroy', 'show', 'update',
    ]);

    Route::get('/employee', [EmployeeController::class, 'search']);

    Route::resource('issue', IssueItemController::class)->only([
        'show', 'store', 'update',
    ]);
    Route::get('/issue', [IssueItemController::class, 'employee']);
    Route::get('/return/{issue}', [ReturnController::class, 'show']);

    Route::get('/histories', [HistoryController::class, 'index']);
    Route::get('/histories/{employeeId}', [HistoryController::class, 'show']);

    // Route::get('/history', [HistoryController::class, 'index']);
    // Route::get('/history', [HistoryController::class, 'search']);

    Route::resource('users', UserController::class)->only([
        'index', 'store', 'destroy',
    ]);
    Route::get('/users/search', [UserController::class, 'searchUser']);

    Route::get('/users/profile', [ProfileController::class, 'index']);
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
