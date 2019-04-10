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

Route::get('/addHabitacion', 'HabitacionController@indexPrincipal');

Route::get ('/editar', function (){
   return view('editar'); 
});

Route::get ('/mantenimiento', function (){
   return view('mantenimiento'); 
});


Route::get('habitacion/{id}/edit', [
    'uses' => 'HabitacionController@edit',
    'as' => 'habitacion.edit'
]);


Route::post('/update/{id}',[
    'uses' => 'HabitacionController@update',
    'as' => 'habitacion.update'
]);


Route::post('/updateCuartos/{id}', 'HabitacionController@updateCuartos' );


Route::get('/mostrar', 'HabitacionController@index');

Route::post('/save', 'HabitacionController@store');
