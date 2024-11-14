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


    Route::post('/login', [
        'uses'  => 'Api\LoginController@login',
        'as'    => 'api.login',
    ]);

	Route::group(['middleware' => 'with_api_key'], function() {


        Route::group(['prefix' => 'user'], function () {

            Route::post('/create', [
                'uses'  => 'Api\UserController@add',
                'as'    => 'api.user.create',
            ]);

            Route::group(['middleware' => 'auth_superAdmin'], function() {

                Route::post('/update/{id}', [
                    'uses'  => 'Api\UserController@update',
                    'as'    => 'api.user.update',
                ]);

                Route::post('/password/{id}', [
                    'uses'  => 'Api\UserController@password',
                    'as'    => 'api.user.password',
                ]);

                Route::post('/delete', [
                    'uses'  => 'Api\UserController@delete',
                    'as'    => 'api.user.delete',
                ]);


	        });

        });

        Route::post('/logout', [
            'uses'  => 'Api\LoginController@logout',
            'as'    => 'api.logout',
        ]);

	});


