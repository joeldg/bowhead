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
Route::get('/setup', 'Controller@setup');
Route::post('/setup2', 'Controller@setup2');
Route::get('/setup2', 'Controller@setup2b'); // in case someone right-clicks and tries to open a url.
Route::post('/setup3', 'Controller@setup3');
Route::post('/setup4', 'Controller@setup4');
Route::post('/exchanges', 'Controller@exchanges');
Route::get('/exchanges', 'Controller@exchanges');
Route::post('/main', 'Main@main');
Route::get('/main', 'Main@main');
