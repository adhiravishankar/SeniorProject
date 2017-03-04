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

/** @var \Illuminate\Routing\Router $router */
$router->get('/', function () {
    return view('welcome');
})->name('home');

$router->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$router->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$router->post('google-register', 'Auth\RegisterController@googleRegistration')->name('googleRegistration');
$router->get('profile', 'ProfileController@profile')->name('profile');
$router->get('edit-profile', 'ProfileController@editProfile')->name('editProfile');
$router->get('colleges', 'CollegesController@index')->name('collegesList');
$router->get('colleges/{id}', 'CollegesController@details')->name('collegesDetails');
$router->get('colleges/search', 'CollegesController@search')->name('collegesSearch');
$router->get('majors', 'MajorsController@index')->name('majorsList');
$router->get('majors/{id}', 'MajorsController@details')->name('majorsDetails');
$router->get('majors/search', 'MajorsController@search')->name('majorsSearch');
$router->get('acceptances', 'AcceptancesController@index')->name('acceptancesList');
$router->get('acceptances/{college}/{major}', 'AcceptancesController@details')->name('acceptancesDetails');