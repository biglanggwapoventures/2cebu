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

Route::group(['as' => 'user.', 'namespace' => 'User', 'prefix' => 'user'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::post('attraction/{attractionId}/review', 'ReviewController@submitReview')->name('review');
        Route::post('attraction/like', 'LikeAttractionController')->name('attraction.like');
        Route::get('profile', 'ProfileController')->name('profile');
        Route::patch('profile', 'ProfileController@update')->name('profile.update');
    });

    Route::resource('attraction', 'AttractionController');
});

Route::patch('review/{id}/status', 'User\ReviewController@setStatus')->name('review.set-status');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {
    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('/', 'DashboardController')->name('dashboard');
        Route::resource('user', 'UserController');
        Route::resource('attraction-category', 'AttractionCategoryController');
        Route::resource('attraction', 'AttractionController');
    });

    Route::group(['prefix' => 'attraction/{attraction}', 'as' => 'attraction.', 'middleware' => 'auth'], function () {
        Route::patch('accomodation', 'AccomodationController@update')->name('accomodation.update');
        Route::patch('transportation', 'TransportationController@update')->name('transportation.update');
        Route::patch('delicacy', 'DelicacyController@update')->name('delicacy.update');
        Route::patch('activity', 'ActivityController@update')->name('activity.update');
        Route::patch('photo', 'PhotoController@update')->name('photo.update');
    });
});
