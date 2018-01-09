<?php

Route::view('/', 'welcome');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {
    Route::resource('user', 'UserController');
    Route::resource('attraction-category', 'AttractionCategoryController');
    Route::resource('attraction', 'AttractionController');
    Route::group(['prefix' => 'attraction/{attraction}', 'as' => 'attraction.'], function () {
        Route::patch('accomodation', 'AccomodationController@update')->name('accomodation.update');
        Route::patch('transportation', 'TransportationController@update')->name('transportation.update');
        Route::patch('delicacy', 'DelicacyController@update')->name('delicacy.update');
        Route::patch('activity', 'ActivityController@update')->name('activity.update');
    });
});