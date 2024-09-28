<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/groups', [GroupController::class, 'getAll']);
Route::get('/groups/{id}', [GroupController::class, 'getById']);

Route::get('/topics/{id}', [TopicController::class, 'getById']);
