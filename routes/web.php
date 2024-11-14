<?php

use Illuminate\Http\Request;
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

Auth::routes();

Route::get('/', [
    'uses'  => 'Auth\LoginController@index',
]);

Route::get('/login', [
    'uses'  => 'Auth\LoginController@index',
    'as'    => 'login.index',
]);

Route::post('/login', [
    'uses'  => 'Auth\LoginController@login',
    'as'    => 'login.validate'
]);

Route::group(['middleware' => 'auth'], function () {


    Route::get('/signout', [
        'uses'  => 'Auth\LoginController@logout',
        'as'    => 'signout'
    ]);

    Route::get('/', [
        'uses' => 'Dashboard\DashboardController@index',
        'as' => 'dashboard.index'
    ]);

    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', [
            'uses' => 'User\UserController@index',
            'as' => 'admin.index'
        ]);

        Route::get('/create', [
            'uses' => 'User\UserController@create',
            'as' => 'admin.create'
        ]);

        Route::post('/create', [
            'uses' => 'User\UserController@add',
            'as' => 'admin.add'
        ]);

        Route::get('/edit/{id}', [
            'uses' => 'User\UserController@edit',
            'as' => 'admin.edit'
        ]);

        Route::post('/edit/{id}', [
            'uses' => 'User\UserController@update',
            'as' => 'admin.update'
        ]);

        Route::post('/password/{id}', [
            'uses' => 'User\UserController@password',
            'as' => 'admin.password'
        ]);

        Route::post('/delete', [
            'uses' => 'User\UserController@delete',
            'as' => 'admin.delete'
        ]);

        Route::post('/adminDatatable', [
            'uses' => 'User\UserController@adminDatatable',
            'as' => 'admin.adminDatatable'
        ]);

    });

});

