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
$router->get('/', 'ProfileController@home')->name('home');
$router->get('/home', 'ProfileController@home2');
$router->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$router->get('logout', 'Auth\LoginController@logout')->name('logout');
$router->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$router->post('google-register', 'Auth\RegisterController@googleRegistration')->name('googleRegistration');
$router->get('profile', 'ProfileController@profile')->name('profile');
$router->get('edit-profile', 'ProfileController@editProfile')->name('editProfile');
$router->post('postprofile', 'ProfileController@postProfile')->name('postProfile');
$router->get('colleges', 'CollegesController@index')->name('collegesList');
$router->post('colleges/add', 'CollegesController@postAdd')->name('collegesPostAdd');
$router->get('colleges/add', 'CollegesController@add')->name('collegesAdd');
$router->get('colleges/search', 'CollegesController@search')->name('collegesSearch');
$router->get('colleges/{id}', 'CollegesController@details')->name('collegesDetails');
$router->get('majors', 'MajorsController@index')->name('majorsList');
$router->get('majors/{id}', 'MajorsController@details')->name('majorsDetails');
$router->get('majors/search', 'MajorsController@search')->name('majorsSearch');
$router->get('acceptances', 'AcceptancesController@index')->name('acceptancesList');
$router->get('acceptances/{college}/{major}', 'AcceptancesController@details')->name('acceptancesDetails');
$router->post('acceptance', 'AcceptancesController@postAcceptance')->name('postAcceptance');
