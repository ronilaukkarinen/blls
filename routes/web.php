<?php
// Stuff to happen when logged out
Route::get('/', 'IndexController@index')->name('index');
Route::get('/login', 'LoginController@index')->name('login');
Route::post('/login', 'LoginController@store');
Route::get('/verify/{token}', 'VerifyController')->name('verify');
Route::get('/reset-password', 'ResetPasswordController@get')->name('reset_password');
Route::post('/reset-password', 'ResetPasswordController@post');
Route::get('/register', 'RegisterController@index')->name('register');
Route::post('/register', 'RegisterController@store');

// Stuff to happen when logged in
Route::group(['middleware' => ['auth']], function () {

    // Bills
    Route::get('/dashboard/', 'BillController@showBills')->name('dashboard');
    Route::post('/addbill', 'BillController@addBill');
    Route::post('/editbill', 'BillController@editBill');
    Route::post('/markaspaid', 'BillController@markasPaid');

    Route::resource('/recurrings', 'RecurringController')->only([
        'index',
        'create',
        'store',
        'show'
    ]);

    Route::resource('/tags', 'TagController')->only([
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy'
    ]);

    Route::get('/reports', 'ReportController@index')->name('reports.index');
    Route::get('/reports/{slug}', 'ReportController@show');

    Route::name('settings.')->group(function () {
        Route::get('/settings', 'SettingsController@getIndex')->name('index');
        Route::post('/settings', 'SettingsController@postIndex');
        Route::get('/settings/profile', 'SettingsController@getProfile')->name('profile');
        Route::get('/settings/account', 'SettingsController@getAccount')->name('account');
        Route::get('/settings/preferences', 'SettingsController@getPreferences')->name('preferences');
        Route::get('/settings/spaces', 'SettingsController@getSpaces')->name('spaces.index');
    });

    Route::get('/spaces/{id}', 'SpaceController');

    Route::name('ideas.')->group(function () {
        Route::get('/ideas/create', 'IdeaController@create')->name('create');
        Route::post('/ideas', 'IdeaController@store');
    });
});

Route::get('/logout', 'LogoutController@index')->name('logout');
