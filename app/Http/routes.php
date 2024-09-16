<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentController;

use App\Http\Middleware\InstructorAuth;
use App\Http\Middleware\StudentAuth;

$router->group(['prefix' => 'api/v1'],  		
	       ['uses'  => 'GuestController@indexInstructors'],
	       function () use ($router) {
	          $router->get('instructors', function () {});
	       });

$router->group(['prefix' => 'api/v1'],  		
	       ['uses'  => 'GuestController@indexStudents'],
	       function () use ($router) {
		  $router->get('students', function () {});
	       });	

$router->group(['prefix' => 'api/v1'],  		
	       ['uses'  => 'GuestController@indexCourses'],
	       function () use ($router) {
		 $router->get('courses', function () {});
	       });	

$router->group(['prefix' => 'api/v1'],  		
	       ['uses'  => 'GuestController@indexInstructorsStats'],
	       function () use ($router) {
	         $router->get('instructors/stats', function () {});
	       });					
								
$router->group(['prefix' => 'api/v1'],  		
	       ['uses'  => 'GuestController@showInstructor', 'as' => 'instructors.show'],
	       function () use ($router) {
	         $router->get('instructors/{instructorId:[0-9]+}', function ($instructorId) {});
	       });

$router->group(['prefix' => 'api/v1'],  		
	       ['uses'  => 'GuestController@showStudent','as' => 'students.show'],
	       function () use ($router) {
	          $router->get('students/{studentId:[0-9]+}', function ($studentId) {});
	       });
			  
$router->group(['prefix' => 'api/v1'],  		
	       ['uses'  => 'GuestController@showCourse','as' => 'courses.show'],
	       function () use ($router) {
	          $router->get('courses/{courseId:[0-9]+}', function ($courseId) {});
	       });
		  
$router->group(['prefix' => 'api/v1'],  		
	       ['uses'  => 'GuestController@showInstructorStats','as' => 'instructorStats.show'],
	       function () use ($router) {
		  $router->get('instructors/{instructorId:[0-9]+}/stats', function ($instructorId) {});
	       });
			  
$router->group(['prefix' => 'api/v1', 'middleware' => 'auth'],
	       ['uses'  => 'UserController@createInstructor'],
	       function () use ($router) {
	          $router->post('instructors/create', function () {});
	       });
			  
$router->group(['prefix' => 'api/v1','middleware' => 'auth'],
	       ['uses'  => 'UserController@createStudent'],
	       function () use ($router) {
	          $router->post('students/create', function () {});
	       });

$router->group(['prefix' => 'api/v1','middleware' => 'instructor'],
               ['uses'  => 'InstructorController@updateProfile'],
	       function () use ($router) {
		  $router->put('instructors/update', function () {});
	       });
				
$router->group(['prefix' => 'api/v1','middleware' => 'instructor'],
	       [ 'uses'  => 'InstructorController@deleteProfile'],
	       function () use ($router) {
	          $router->delete('instructors/delete', function () {});
	       });

$router->group(['prefix' => 'api/v1','middleware' => 'instructor'],
	       [ 'uses'  => 'InstructorController@createCourse'],
	       function () use ($router) {
		  $router->post('courses/create', function () {});
	       });

$router->group(['prefix' => 'api/v1','middleware' => 'instructor'],
	       ['uses'  => 'InstructorController@updateCourse'],
	       function () use ($router) {
	          $router->put('courses/{courseId:[0-9]+}/update', function ($courseId) {});
	       });

$router->group(['prefix' => 'api/v1','middleware' => 'instructor'],
	       ['uses'  => 'InstructorController@deleteCourse'],
	       function () use ($router) {
		   $router->delete('courses/{courseId:[0-9]+}/delete', function ($courseId) {});
	       });

$router->group(['prefix' => 'api/v1','middleware' => 'student'],
	       ['uses'  => 'StudentController@updateProfile'],
	       function () use ($router) {
	          $router->put('students/update', function () {});
	       });
				
$router->group(['prefix' => 'api/v1','middleware' => 'student'],
	       ['uses'  => 'StudentController@deleteProfile'],
	       function () use ($router) {
		  $router->delete('students/delete', function () {});
	       });
				
$router->group(['prefix' => 'api/v1','middleware' => 'student'],
	       ['uses'  => 'StudentController@createCourseRating'],
	       function () use ($router) {
	         $router->post('students/courses/{courseId:[0-9]+}/rating/create', function ($courseId) {});
	       });
