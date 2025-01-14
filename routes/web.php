<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'web'], function () {
    Auth::routes();

    /*// Login Routes...
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

    // Registration Routes...
    Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
    Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);

    // Password Reset Routes...
    Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);
    */
    Route::get('logout', 'Auth\LoginController@logout');

    Route::get('/home', 'HomeController@index');
});

/*Nachfolgende Routen können nur dann aufgerufen werden, wenn der User eingeloggt ist
 *Andernfalls wird der User zur Home-Route (Login) umgeleitet
 */
Route::group(['middleware' => 'auth'], function () {
    Route::resource('buildings', 'BuildingsController');
    Route::resource('objects', 'ObjectsController');
    Route::resource('renter', 'RenterController');
    Route::resource('payments', 'PaymentsController');
    Route::resource('invoices', 'InvoicesController');

    Route::get('/report', 'ReportController@showReportView');
    Route::get('/building_overview_pdf', 'ReportController@createBuildingsPDF');
    Route::get('/renter_directory_pdf', 'ReportController@createRenterDirectoryPDF');

    Route::post('/createPDF', 'ReportController@createPDF');

    /*
     * Ajax routes
     */
    Route::get('/getBuildingData/{id}', 'RenterController@getBuildingData');
    Route::get('/getRenterData/{id}', 'PaymentsController@getRenterData');
    Route::get('/getObjectData/{id}', 'InvoicesController@getObjectData');
    Route::post('/changePaymentBooleanIsPaid', 'PaymentsController@changeBooleanIsPaid');
    Route::post('/renter/changePaymentBooleanIsPaid', 'PaymentsController@changeBooleanIsPaid');
    Route::get('/getFilteredPayments', 'PaymentsController@getFilteredPayments');
    Route::post('/changeInvoiceBooleanIsPaid', 'InvoicesController@changeBooleanIsPaid');
});



