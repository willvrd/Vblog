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

/*
* name: locale.admin.vblog
*/

Route::middleware('auth')->prefix('/vblog')->name('.vblog')->group(function(){

    require('BackendRoutes/postRoutes.php');
    require('BackendRoutes/categoryRoutes.php');

});
