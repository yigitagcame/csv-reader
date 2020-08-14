<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/file/{id}', 'FileController@show');

Route::post('/file/create', 'FileController@store');

Route::post('/file/{id}/edit', 'FileController@update');

// Csv Routes

Route::get('/csv', 'CsvController@index');

Route::get('/csv/{id}', 'CsvController@show');

// Compute Routess

Route::post('/compute/create', 'ComputeController@store');
