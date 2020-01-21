<?php

Route::group(['middleware' => ['web']], function () {

    Route::get('render/{accessToken}', 'BlockScreenshotController@renderBlockForThumb')->name('render-block-thumb');

});