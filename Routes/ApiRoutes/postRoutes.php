<?php

use Illuminate\Http\Request;

Route::prefix('/posts')->name('.posts')->middleware('auth:api')->group(function(){

    Route::get('/', 'Api\PostApiController@index')
    ->name('.index')
    ->middleware('can:vblog.posts.index');

    Route::get('/{criteria}', 'Api\PostApiController@show')
    ->name('.show')
    ->middleware('can:vblog.posts.index');

    Route::post('/', 'Api\PostApiController@create')
    ->name('.create')
    ->middleware('can:vblog.posts.create');

    Route::put('/{criteria}', 'Api\PostApiController@update')
    ->name('.update')
    ->middleware('can:vblog.posts.update');

    Route::delete('/{criteria}', 'Api\PostApiController@delete')
    ->name('.delete')
    ->middleware('can:vblog.posts.delete');

});
