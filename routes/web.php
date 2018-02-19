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
Route::get('admin/user','AdminController@userlist')->name('admin.user_list'); 
Route::get('admin/user/{id}', 'AdminController@userview')->name('admin.user')->where(['id' => '[0-9]+']);
Route::post('admin/user/edit/{id}', 'AdminController@useredit')->name('user.edit')->where(['id' => '[0-9]+']);
Route::post('admin/user/reset_password/{id}', 'AdminController@user_reset_password')->name('user.reset_password')->where(['id' => '[0-9]+']);
Route::get('admin/user/delete/{id}','AdminController@deleteuser')->name('admin.user_delete')->where(['id'=>'[0-9]+']);



