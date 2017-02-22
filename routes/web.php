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
    return view('welcome');
})->name('home');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('colleges', 'CollegesController@index')->name('collegesList');
Route::get('colleges/{id}', 'CollegesController@details')->name('collegesDetails');
Route::get('colleges/search', 'CollegesController@search')->name('collegesSearch');
Route::get('majors', 'MajorsController@index')->name('majorsList');
Route::get('majors/{id}', 'MajorsController@details')->name('majorsDetails');
Route::get('majors/search', 'MajorsController@search')->name('majorsSearch');
Route::get('acceptances', 'AcceptancesController@index')->name('acceptancesList');
Route::get('acceptances/{id}', 'AcceptancesController@details')->name('acceptancesDetails');
Route::get('acceptances/search', 'AcceptancesController@search')->name('acceptancesSearch');
