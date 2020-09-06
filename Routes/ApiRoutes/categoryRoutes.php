<?php

use Illuminate\Http\Request;

Route::prefix('/categories')->name('.categories')->middleware('auth:api')->group(function(){

    Route::get('/', 'Api\CategoryApiController@index')
    ->name('.index')
    ->middleware('can:vblog.categories.index');

    Route::get('/{criteria}', 'Api\CategoryApiController@show')
    ->name('.show')
    ->middleware('can:vblog.categories.index');

    Route::post('/', 'Api\CategoryApiController@create')
    ->name('.create')
    ->middleware('can:vblog.categories.create');

    Route::put('/{criteria}', 'Api\CategoryApiController@update')
    ->name('.update')
    ->middleware('can:vblog.categories.update');

    Route::delete('/{criteria}', 'Api\CategoryApiController@delete')
    ->name('.delete')
    ->middleware('can:vblog.categories.delete');

});
