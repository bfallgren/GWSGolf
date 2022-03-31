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

/* Default Routes*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* App Resources */
Route::resource('clubs', 'ClubController');
Route::resource('courses', 'CourseController');
Route::resource('homeclub', 'HomeClubController');
Route::resource('ratings', 'CourseRatingController');
Route::resource('scores', 'ScoreController');
Route::resource('archives', 'ArchiveController');

Route::group(['middleware' => ['auth']], function () {

    // My Routes
    /* THE FOLLOWING ARE USED FOR ALIAS IN APPS.BLADE.PHP */
    Route::get('clubs', array('as' => 'golfclubs', 'uses' => 'ClubController@index'));
    Route::get('courses', array('as' => 'golfcourses', 'uses' => 'CourseController@index'));
    Route::get('homeclub', array('as' => 'myclub', 'uses' => 'HomeClubController@index'));
    Route::get('ratings', array('as' => 'courserating', 'uses' => 'CourseRatingController@index'));
    Route::get('ratings/{rating}', ['as' => 'ratings.index', 'uses' => 'CourseRatingController@index']);
    Route::get('scores', array('as' => 'golfscores', 'uses' => 'ScoreController@index'));
    Route::get('archives', array('as' => 'allscores', 'uses' => 'ArchiveController@index'));
    //index searches
    Route::get('fetchCourses', 'CourseController@fetchCourses'); /* course search Route */
   

    /* THE FOLLOWING IS USED TO POPULATE SCORE FORMS*/
    Route::get('scores/getTee/{courseID}', 'ScoreController@getTee');
    Route::get('scores/getCourseID/{courseName}', 'ScoreController@getCourseID');

});


