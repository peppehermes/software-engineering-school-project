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



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'HomeController@admin')->middleware('admin');

//user
Route::group(['prefix' => 'user','middleware'=>['parents']], function() {
    Route::get('/add', 'UserController@add')->middleware('admin');
    Route::get('/edit/{id}', 'UserController@edit');
    Route::post('/update/{id}', 'UserController@update');
    Route::get('/list', 'UserController@list')->middleware('admin');
    Route::post('/store', 'UserController@store')->middleware('admin');
    Route::get('/delete/{id}', 'UserController@delete')->middleware('admin');
});


//student
Route::group(['prefix' => 'student'], function() {
    Route::get('/add', 'StudentController@add')->middleware('admin');
    Route::get('/edit/{id}', 'StudentController@edit')->middleware('admin');
    Route::post('/update/{id}', 'StudentController@update')->middleware('admin');
    Route::get('/list', 'StudentController@list')->middleware('admin');
    Route::post('/store', 'StudentController@store')->middleware('admin');
    Route::post('/storeParent/{id}', 'StudentController@storeParent')->middleware('admin');
    Route::get('/delete/{id}', 'StudentController@delete')->middleware('admin');
    Route::get('/showmarks/{id}', 'StudentController@showmarks')->middleware('parents');
});

//teacher
Route::group(['prefix' => 'teacher'], function() {
    Route::get('/add', 'TeacherController@add')->middleware('admin');
    Route::get('/edit/{id}', 'TeacherController@edit')->middleware('admin');
    Route::post('/update/{id}', 'TeacherController@update')->middleware('admin');
    Route::get('/list', 'TeacherController@list')->middleware('admin');
    Route::post('/store', 'TeacherController@store')->middleware('admin');
    Route::get('/delete/{id}', 'TeacherController@delete')->middleware('admin');
});

//classroom
Route::group(['prefix' => 'classroom'], function() {
    Route::get('/add', 'ClassroomController@add')->middleware('admin');
    Route::get('/edit/{id}', 'ClassroomController@edit')->middleware('admin');
    Route::post('/update/{id}', 'ClassroomController@update')->middleware('admin');
    Route::get('/list', 'ClassroomController@list')->middleware('admin');
    Route::post('/store', 'ClassroomController@store')->middleware('admin');
    Route::get('/delete/{id}', 'ClassroomController@delete')->middleware('admin');
    Route::get('/composition/{id}', 'ClassroomController@composition')->middleware('admin');
    Route::get('/deleteStudent/{id}', 'ClassroomController@deleteStudent')->middleware('admin');
    Route::post('/classComposition/{id}', 'ClassroomController@classComposition')->middleware('admin');
});


//LectTopic
Route::group(['prefix' => 'topic'], function() {
    Route::get('/add', 'TeacherController@addtopic')->middleware('teachers');
    Route::get('/list', 'TeacherController@listtopic')->middleware('teachers');
    Route::post('/storetopic', 'TeacherController@storetopic')->middleware('teachers');
    Route::get('/listforparents/{idStud}', 'StudentController@listforparents')->middleware('parents');
});
