<?php

/*
* name: locale.admin.vblog.categories
*/

 //Posts
 Route::prefix('categories')->name('.categories')->group(function () {

    // Index
    Route::get('/', 'Admin\CategoryController@index')
    ->name('.index')
    ->middleware('can:vblog.categories.index');

});
