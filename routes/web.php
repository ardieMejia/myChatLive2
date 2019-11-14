<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat', function(Request $request){
    return view('chat',['username'=>$request->username]);
});

Route::get('/long-polling', 'LongPollingController@longpolling');
Route::get('/messageUpdateTable', 'LongPollingController@messages');
