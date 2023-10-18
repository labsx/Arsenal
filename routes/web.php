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

Route::get('/dashboard', [LoginController::class, 'index']);
Route::middleware('auth')->group(function () {
    Route::resource('category', CategoryController::class)
        ->only(['index', 'store', 'destroy', 'update', 'show']);

    Route::resource('field-group', FieldGroupController::class)->only([
        'index', 'store', 'destroy', 'update', 'show',
    ]);
    Route::get('/field-groups/{id}/fields', [FieldGroupController::class, 'getFieldsByFieldGroupId']);

    Route::resource('fields', FieldController::class)->only([
        'index', 'store', 'destroy', 'update', 'show'
    ]);
    Route::get('/fields/{id}/show', [FieldController::class, 'showFilterFileds']); //table for fields
    Route::get('/fields', [FieldController::class, 'getFieldsDetails']); //fields for edit category

    Route::resource('items', ItemController::class)->only([
        'index', 'store', 'destroy', 'update', 'show',
    ]);
    Route::get('items/{item}/attributes', [ItemController::class, 'getAttributes']);

    Route::resource('parent', ParentController::class)->only([
        'store', 'destroy', 'update',
    ]);
    Route::get('/parent/sub', [ParentController::class, 'getSubCategroy']); //item dropdown
    Route::get('/parent', [ParentController::class, 'search']);
    Route::get('/parent/{id}/show', [ParentController::class, 'showData']); //table
    Route::get('/parent/{parent}', [ParentController::class, 'show']); //dropdown and edit
    // Route::put('/parent/{parent}', [ParentController::class, 'update']);

    Route::resource('employee', EmployeeController::class)->only([
        'index', 'store', 'destroy', 'show', 'update',
    ]);

    Route::resource('issue', IssueItemController::class)->only([
        'index', 'show', 'store',
    ]);

    Route::resource('return', ReturnController::class)->only([
        'show', 'update',
    ]);

    Route::resource('histories', HistoryController::class)->only([
        'index', 'show'
    ]);

    Route::resource('users', UserController::class)->only([
        'index', 'store', 'destroy',
    ]);

    Route::resource('users/profile', ProfileController::class)->only([
        'index', 'store',
    ]);
    Route::put('/users/profile', [ProfileController::class, 'update']);
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
