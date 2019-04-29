<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'fe'], function () {
    Route::group(['prefix' => 'product'], function () {
        Route::post('/importxl','ListHargaController@importxl');
      });
});
