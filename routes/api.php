<?php


Route::group(['namespace' => 'Api'], function () {
    $exceptCreateAndEdit = [
        'except' => ['create', 'edit']
    ];
    
    Route::resource('categories', 'CategoryController', $exceptCreateAndEdit);
    Route::resource('genre', 'GenreController', $exceptCreateAndEdit);
});
