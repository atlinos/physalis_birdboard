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
    Route::resource('projects', 'ProjectsController');

    Route::post('/projects/{project}/persons', 'ProjectPersonsController@store');
    Route::get('/projects/{project}/persons/{person}', 'ProjectPersonsController@show');
    Route::patch('/projects/{project}/persons/{person}', 'ProjectPersonsController@update');
    Route::delete('/projects/{project}/persons/{person}', 'ProjectPersonsController@destroy');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();
