<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('/', 'ProjectsController@index');

    Route::resource('projects', 'ProjectsController');

    Route::get('/projects/{project}/people', 'ProjectPeopleController@index');
    Route::post('/projects/{project}/people', 'ProjectPeopleController@store');
    Route::get('/projects/{project}/people/{person}', 'ProjectPeopleController@show');
    Route::patch('/projects/{project}/people/{person}', 'ProjectPeopleController@update');
    Route::delete('/projects/{project}/people/{person}', 'ProjectPeopleController@destroy');

    Route::post('/projects/{project}/invitations', 'ProjectInvitationsController@store');

    Route::get('/projects/{project}/search', 'SearchController@show');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();
