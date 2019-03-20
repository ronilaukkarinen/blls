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

    // Dashboard
    Route::get('/dashboard', 'DashboardController')->name('dashboard');

    // Tests
    Route::get('/test', 'BillController@testfunction');
    Route::post('/test', 'BillController@testfunction');

    // Bills
    Route::get('/dashboard/', 'BillController@showBills');
    Route::get('/getbills', 'BillController@getBills');

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

    Route::name('imports.')->group(function () {
        Route::get('/imports', 'ImportController@index')->name('index');
        Route::get('/imports/create', 'ImportController@create')->name('create');
        Route::post('/imports', 'ImportController@store')->name('store');
        Route::get('/imports/{import}/prepare', 'ImportController@getPrepare')->name('prepare');
        Route::post('/imports/{import}/prepare', 'ImportController@postPrepare');
        Route::get('/imports/{import}/complete', 'ImportController@getComplete')->name('complete');
        Route::post('/imports/{import}/complete', 'ImportController@postComplete');
        Route::delete('/imports/{import}', 'ImportController@destroy');
    });

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
