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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

/* home controller routes */
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/changepassword', 'HomeController@changepassword')->name('home.changepassword')->middleware('auth');
Route::post('/processchangepassword', 'HomeController@processchangepassword')->name('home.processchangepassword')->middleware('auth');

/* Google authenticate route */
Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('auth.googlelogin');
Route::get('login/google/callback/', 'Auth\LoginController@handleProviderCallback');
 
//contribute section 
Route::get('suggest-new-places','ContributeController@index')->name('contribute.index'); 
Route::post('contribute/submit','ContributeController@submit')->name('contribute.submit');
Route::get('daily-login-points','ContributeController@dailyLoginPoints')->name('contribute.dailylogin')->middleware('auth');
Route::get('know-your-points','ContributeController@expectedPoints')->name('contribute.expectedpoints')->middleware('auth');
Route::get('register-points','ContributeController@registerPoints')->name('contribute.registerpoints')->middleware('auth');

//admin section 
Route::get('admin/dashboard','AdminController@index')->name('admin.dashboard'); 
