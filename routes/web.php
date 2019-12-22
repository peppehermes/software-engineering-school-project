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

use App\Http\Middleware\ClassCoordinator;

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'HomeController@admin')->middleware('admin');

//user
Route::group(['prefix' => 'user','middleware'=>'superadmin'], function() {
    Route::get('/add', 'UserController@add');
    Route::get('/list', 'UserController@list');
    Route::post('/store', 'UserController@store');
    Route::get('/delete/{id}', 'UserController@delete');
});

//admin and parent
Route::group(['prefix' => 'user'], function() {
    Route::get('/edit/{id}', 'UserController@edit');
    Route::post('/update/{id}', 'UserController@update');
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
    Route::get('/attendance/{id}/{date}', 'StudentController@attendance')->middleware('teachers');
    Route::post('/saveattendance/{id}', 'StudentController@saveattendance')->middleware('teachers');
    Route::get('/attendance_report/{id}', 'StudentController@attendancereport')->middleware('parents');
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
    Route::get('/listforparents/{idStud}', 'StudentController@listTopicforparents')->middleware('parents');
});

//Assignments
Route::group(['prefix' => 'assignment'], function() {
    Route::get('/add', 'TeacherController@addassignment')->middleware('teachers');
    Route::get('/list', 'TeacherController@listassignment')->middleware('teachers');
    Route::post('/storeassignment', 'TeacherController@storeassignment')->middleware('teachers');
    Route::get('/listforparents/{idStud}', 'StudentController@listAssignmentforparents')->middleware('parents');

});

//SuppMaterial
Route::group(['prefix' => 'material'], function() {
    Route::get('/add', 'TeacherController@addmaterial')->middleware('teachers');
    Route::get('/list', 'TeacherController@listmaterial')->middleware('teachers');
    Route::post('/store', 'TeacherController@storematerial')->middleware('teachers');
    Route::get('/listforparents/{idStud}', 'StudentController@listMaterialforparents')->middleware('parents');
});

//Notes
Route::group(['prefix' => 'notes'], function() {
    Route::get('/write', 'TeacherController@writenote')->middleware('teachers');
    Route::get('/list', 'TeacherController@listnotes')->middleware('teachers');
    Route::post('/store', 'TeacherController@storenote')->middleware('teachers');
    Route::get('/shownotes/{id}', 'StudentController@shownotes')->middleware('parents');
});

//Marks
Route::group(['prefix' => 'mark'], function() {
    Route::get('/add', 'TeacherController@addmark')->middleware('teachers');
//    Route::get('/list', 'TeacherController@listmark')->middleware('teachers');
    Route::post('/listmark', 'TeacherController@listmark')->middleware('teachers');
    Route::post('/storemark', 'TeacherController@storemark')->middleware('teachers');
    Route::get('/classes', 'TeacherController@listclasses')->middleware('teachers');
    Route::get('/addnewmark', 'TeacherController@addnewmark')->middleware('teachers');
    Route::post('/storenewmark', 'TeacherController@storenewmark')->middleware('teachers');
    Route::get('/classlist', 'TeacherController@classlist')->middleware('teachers');
});

//Official Communications
Route::group(['prefix' => 'communications'],  function() {
    Route::get('/add', 'CommunicationsController@add')->middleware('admin');
    Route::get('/list', 'CommunicationsController@list')->middleware('parentandadmin');
    Route::post('/store', 'CommunicationsController@store')->middleware('admin');
});

//Meetings
Route::group(['prefix' => 'meetings'],  function() {
    Route::get('/list', 'TeacherController@listtimeslot')->middleware('teachers');
    Route::get('/add', 'TeacherController@addtimeslot')->middleware('teachers');
    Route::get('/addweek', 'TeacherController@addweek')->middleware('teachers');
    Route::post('/store', 'TeacherController@storetimeslot')->middleware('teachers');
    Route::post('/storeall', 'TeacherController@storealltimeslot')->middleware('teachers');
    Route::post('/free', 'TeacherController@freetimeslot')->middleware('teachers');
    Route::get('/choose/{idStud}', 'StudentController@chooseteacher')->middleware('parents');
    Route::post('/book/{idStud}', 'StudentController@seeTeacherMeetingSlot')->middleware('parents');
    Route::post('/storeforparents', 'StudentController@storeMeetingForParent')->middleware('parents');
    Route::post('/freeforparents', 'StudentController@freeMeetingForParent')->middleware('parents');
    Route::get('/listforparents', 'StudentController@meetingListForParents')->middleware('parents');
});


//Timetables
Route::group(['prefix' => 'timetable'],  function() {
    Route::get('/add', 'TimetableController@add')->middleware('admin');
    Route::post('/store', 'TimetableController@store')->middleware('admin');
    Route::get('/list', 'TimetableController@list');
    Route::post('/show', 'TimetableController@show');
    Route::get('/listforparents/{idStud}', 'StudentController@timetableForStudent')->middleware('parents');
    Route::get('/chooseclass', 'TimetableController@chooseclass')->middleware('admin');
    Route::post('/addmanual', 'TimetableController@addmanual')->middleware('admin');
    Route::post('/storemanual/{idClass}', 'TimetableController@storemanual')->middleware('admin');
});

//Final grades
Route::group(['prefix' => 'finalgrades'],  function() {
    Route::get('/insert', 'TeacherController@insertFinalGrades')->middleware(ClassCoordinator::class);
    Route::post('/store/{idClass}', 'TeacherController@storeFinalGrades')->middleware(ClassCoordinator::class);
    Route::get('/show', 'TeacherController@showFinalGrades')->middleware(ClassCoordinator::class);
    Route::get('/listforparents/{idStud}', 'StudentController@listFinalGradesforparents')->middleware('parents');
    Route::get('/download/{idClass}', 'TeacherController@downloadTemplate')->middleware(ClassCoordinator::class);
});
