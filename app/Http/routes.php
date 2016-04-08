<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
        return view('welcome');
});
Route::get('/lobby', 'LobbyController@index');
Route::auth();
Route::get('/home', 'HomeController@index');
Route::get('/room/{id}', 'RoomController@index');
Route::get('/room/check/{pass}', 'RoomController@check');
Route::post('/room/create', 'RoomController@create');
Route::get('/leaderboard', 'LeaderboardController@index');
Route::post('/chat', 'LobbyController@sendChat');
Route::post('/move', 'RoomController@move');
Route::post('/saveinfoplay', 'RoomController@saveinfoplay');
Route::get('/getchat/{last}', 'LobbyController@getChat');
Route::get('/getroom', 'LobbyController@getRoom');
Route::get('/ready', 'RoomController@ready');
Route::get('/waitPlayer', 'RoomController@waitPlayer');
Route::get('/countdown', 'RoomController@countdown');
Route::get('/runaway', 'RoomController@runaway');
Route::get('/updateboard', 'RoomController@updateboard');
Route::get('/updateinfo', 'RoomController@updateinfo');
Route::get('/playerwithdraw', 'RoomController@playerwithdraw');
Route::get('/getidplayer', 'RoomController@getidplayer');
Route::get('/seeinside/{id}', 'LobbyController@seeinside');

