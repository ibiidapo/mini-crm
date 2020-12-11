<?php
declare(strict_types=1);

Route::auth(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::view('/', 'index')
         ->name('index');
    Route::view('/home', 'index')
         ->middleware('auth')
         ->name('home');
    Route::resource('clients', 'ClientsController');
    Route::resource('transactions', 'TransactionsController');
    Route::get('search/clients', 'AutocompleteController@searchClients')
         ->name('search.clients');
});
