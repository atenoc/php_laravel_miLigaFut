<?php

use Illuminate\Support\Facades\Route;

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

/*Ruta para el controlador del Admin*/
Route::resource('admin/users','AdminUsersController');
  //Ruta al eliminar un usuario
  Route::post('deleteUser/{id}', 'AdminUsersController@destroy');


Route::resource('ligas','LigasController');
  //Ruta al eliminar una liga
  Route::post('deleteLiga/{id}', 'LigasController@destroy');
