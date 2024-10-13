<?php

use App\Http\Controllers\CacheController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\VocabularyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cache/checkConnection', [CacheController::class, 'checkConnection']);
Route::delete('/cache/flushAll', [CacheController::class, 'flushAll']);

Route::get('/groups', [GroupController::class, 'getMultiple']);
Route::get('/groups/{id}', [GroupController::class, 'getById'])->where('id', '[0-9]+');
Route::get('/groups/{id}/topics', [GroupController::class, 'getListTopicsById'])->where('id', '[0-9]+');
Route::get('/groups/readFromCsvFile', [GroupController::class, 'readFromCsvFile']);

Route::get('/topics/{id}', [TopicController::class, 'getById'])->where('id', '[0-9]+');
Route::get('/topics/readFromCsvFile', [TopicController::class, 'readFromCsvFile']);

Route::get('/vocabularies/{id}', [VocabularyController::class, 'getById'])->where('id', '[0-9]+');
Route::get('/vocabularies/readFromCsvFile', [VocabularyController::class, 'readFromCsvFile']);
