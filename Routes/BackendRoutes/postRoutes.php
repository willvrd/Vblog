<?php

/*
* name: locale.admin.vblog.posts
*/

 //Posts
 Route::prefix('posts')->name('.posts')->group(function () {

    // Index
    Route::get('/', 'Admin\PostController@index')
    ->name('.index')
    ->middleware('can:vblog.posts.index');

});
