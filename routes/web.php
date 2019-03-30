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
    Route::get('/dashboard', 'BillController@showBills')->name('dashboard');
    Route::post('/addbill', 'BillController@addBill');
    Route::post('/editbill', 'BillController@editBill');
    Route::post('/markaspaid', 'BillController@markasPaid');
    Route::post('/markasunpaid', 'BillController@markasunPaid');
    Route::post('/removebill', 'BillController@removeBill');

    // Subscriptions
    Route::post('/addsubscription', 'SubscriptionController@addSubscription');
    Route::post('/removesubscription', 'SubscriptionController@removeSubscription');
    Route::post('/editsubscription', 'SubscriptionController@editSubscription');
    Route::post('/handlesubscription', 'SubscriptionController@handleSubscription');
    Route::post('/updatesubscriptiondate', 'SubscriptionController@updateSubscriptionDate');

    // Payment plans
    Route::post('/addpaymentplan', 'PaymentplanController@addPaymentplan');
    Route::post('/editpaymentplan', 'PaymentplanController@editPaymentplan');
    Route::post('/removepaymentplan', 'PaymentplanController@removePaymentplan');
    Route::post('/markppaid', 'PaymentplanController@markaPaymentplanasPaid');
    Route::post('/markpunpaid', 'PaymentplanController@markaPaymentplanasunPaid');

    // Credit cards
    Route::post('/addcreditcard', 'CreditcardController@addCreditcard');
    Route::post('/editcreditcard', 'CreditcardController@editCreditcard');
    Route::post('/removecreditcard', 'CreditcardController@removeCreditcard');

    // Paid page
    Route::get('/paid', 'PaidController@showPaid')->name('paid');

    // Settings
    Route::name('settings.')->group(function () {
        Route::get('/settings', 'SettingsController@getIndex')->name('index');
        Route::post('/settings', 'SettingsController@postIndex');
        Route::get('/settings/profile', 'SettingsController@getProfile')->name('profile');
        Route::get('/settings/account', 'SettingsController@getAccount')->name('account');
        Route::get('/settings/preferences', 'SettingsController@getPreferences')->name('preferences');
        Route::get('/settings/spaces', 'SettingsController@getSpaces')->name('spaces.index');
    });

    Route::get('/spaces/{id}', 'SpaceController');
});

Route::get('/logout', 'LogoutController@index')->name('logout');
