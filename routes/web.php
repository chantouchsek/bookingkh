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
    $results = DB::select( DB::raw("select version()") );
    $mysql_version =  $results[0]->{'version()'};
    $mariadb_version = '';

    if (strpos($mysql_version, 'Maria') !== false) {
        $mariadb_version = $mysql_version;
        $mysql_version = '';
    }
    dd($mysql_version >= '5.6');
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
