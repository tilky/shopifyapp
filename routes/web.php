<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/redirects', 'RedirectsController@index')->name('redirects.index');

Route::get('/redirects/create', 'RedirectsController@create')->name('redirects.create');

Route::get('/redirects/import', 'RedirectsController@import')->name('redirects.import');

Route::get('/redirects/edit/{id}', 'RedirectsController@edit')->name('redirects.edit');

Route::post('/redirects/create/store', 'RedirectsController@store')->name('redirects.store');

Route::post('/redirects/edit/update', 'RedirectsController@update')->name('redirects.update');

Route::post('/redirects/import/process', 'RedirectsController@processImport')->name('redirects.processImport');

Route::get('/redirects/destroy/{id}', 'RedirectsController@destroy')->name('redirects.destroy');