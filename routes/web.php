<?php

Route::get('/', 'HomeController')->name('home');
Route::post('logout', 'LogoutController')->name('logout');

Route::group(['middleware' => 'guest', 'as' => 'guest.'], function () {
    Route::post('register', 'RegistrationController')->name('register');
    Route::post('login', 'LoginController')->name('login');
    Route::group(['namespace' => 'Auth', 'as' => 'auth:', 'prefix' => 'auth'], function () {
        Route::get('facebook', 'FacebookController@redirectToProvider')->name('facebook');
        Route::get('facebook/callback', 'FacebookController@handleProviderCallback');
        Route::get('google', 'GoogleController@redirectToProvider')->name('google');;
        Route::get('google/callback', 'GoogleController@handleProviderCallback');
    });
});

Route::group(['as' => 'user.', 'namespace' => 'User'], function () {
    Route::resource('attraction', 'AttractionController');
    Route::post('attraction/{attractionId}/review', 'ReviewController@submitReview')->name('review');
});

Route::patch('review/{id}/status', 'User\ReviewController@setStatus')->name('review.set-status');

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
