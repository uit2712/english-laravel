<?php

use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/groups', [GroupController::class, 'getAll']);
Route::get('/groups/{id}', [GroupController::class, 'getById']);
