<?php


Route::group(['namespace' => 'Api'], function () {
    Route::resource('categories', 'CategoryController', [ 'except' => [ 'create', 'edit']]);
    Route::resource('genre', 'GenreController', [ 'except' => [ 'create', 'edit']]);
});
