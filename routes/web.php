<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/projects', 'ProjectsController@index');
    Route::get('/projects/create', 'ProjectsController@create');
    Route::get('/projects/{project}', 'ProjectsController@show');
    Route::patch('/projects/{project}', 'ProjectsController@update');
    Route::delete('/projects/{project}', 'ProjectsController@destroy');
    Route::post('/projects', 'ProjectsController@store');

    Route::post('/projects/{project}/persons', 'ProjectPersonsController@store');
    Route::get('/projects/{project}/persons/{person}', 'ProjectPersonsController@show');
    Route::patch('/projects/{project}/persons/{person}', 'ProjectPersonsController@update');
    Route::delete('/projects/{project}/persons/{person}', 'ProjectPersonsController@destroy');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();
