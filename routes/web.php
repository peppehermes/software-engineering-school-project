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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'HomeController@admin')->middleware('admin');

//user
Route::get('/user/add', 'UserController@add')->middleware('admin');
Route::get('/user/edit/{id}', 'UserController@edit')->middleware('admin');
Route::post('/user/update/{id}', 'UserController@update')->middleware('admin');
Route::get('/user/list', 'UserController@list')->middleware('admin');
Route::post('/user/store', 'UserController@store')->middleware('admin');
Route::get('/user/delete/{id}', 'UserController@delete')->middleware('admin');

//student
Route::get('/student/add', 'StudentController@add')->middleware('admin');
Route::get('/student/edit/{id}', 'StudentController@edit')->middleware('admin');
Route::post('/student/update/{id}', 'StudentController@update')->middleware('admin');
Route::get('/student/list', 'StudentController@list')->middleware('admin');
Route::post('/student/store', 'StudentController@store')->middleware('admin');
Route::get('/student/delete/{id}', 'StudentController@delete')->middleware('admin');


//teacher
Route::get('/teacher/add', 'TeacherController@add')->middleware('admin');
Route::get('/teacher/edit/{id}', 'TeacherController@edit')->middleware('admin');
Route::post('/teacher/update/{id}', 'TeacherController@update')->middleware('admin');
Route::get('/teacher/list', 'TeacherController@list')->middleware('admin');
Route::post('/teacher/store', 'TeacherController@store')->middleware('admin');
Route::post('/teacher/delete', 'TeacherController@delete')->middleware('admin');
