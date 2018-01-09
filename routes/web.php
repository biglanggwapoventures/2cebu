<?php

Route::get('/', 'HomeController');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {
    Route::redirect('/', 'admin/user');
    Route::resource('user', 'UserController');
    Route::resource('attraction-category', 'AttractionCategoryController');
    Route::resource('attraction', 'AttractionController');
    Route::group(['prefix' => 'attraction/{attraction}', 'as' => 'attraction.'], function () {
        Route::patch('accomodation', 'AccomodationController@update')->name('accomodation.update');
        Route::patch('transportation', 'TransportationController@update')->name('transportation.update');
        Route::patch('delicacy', 'DelicacyController@update')->name('delicacy.update');
        Route::patch('activity', 'ActivityController@update')->name('activity.update');
        Route::patch('photo', 'PhotoController@update')->name('photo.update');
    });
});
