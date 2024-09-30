<?php

use App\Http\Controllers\CacheController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cache/checkConnection', [CacheController::class, 'checkConnection']);
Route::delete('/cache/flushAll', [CacheController::class, 'flushAll']);

Route::get('/groups', [GroupController::class, 'getAll']);
Route::get('/groups/{id}', [GroupController::class, 'getById']);
Route::get('/groups/{id}/topics', [GroupController::class, 'getListTopicsById']);

Route::get('/topics/{id}', [TopicController::class, 'getById']);
