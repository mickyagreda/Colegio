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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware'=>['auth']],function(){
    Route::get('/',function(){
        return view('contenido/contenido');
    })->name('main');
   

Route::get('/categoria', 'CategoriaController@index');
Route::post('/categoria/registrar', 'CategoriaController@store');
Route::put('/categoria/actualizar', 'CategoriaController@update');
Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
Route::put('/categoria/activar', 'CategoriaController@activar');
Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');

Route::get('/articulo', 'ArticuloController@index');
Route::post('/articulo/registrar', 'ArticuloController@store');
Route::put('/articulo/actualizar', 'ArticuloController@update');
Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
Route::put('/articulo/activar', 'ArticuloController@activar');

Route::get('/profesor', 'ProfesorController@index');
Route::post('/profesor/registrar', 'ProfesorController@store');
Route::put('/profesor/actualizar', 'ProfesorController@update');
Route::put('/profesor/desactivar', 'ProfesorController@desactivar');
Route::put('/profesor/activar', 'ProfesorController@activar');


Route::get('/curso', 'CursoController@index');
Route::post('/curso/registrar', 'CursoController@store');
Route::put('/curso/actualizar', 'CursoController@update');
Route::put('/curso/desactivar', 'CursoController@desactivar');
Route::put('/curso/activar', 'CursoController@activar');
Route::get('/curso/buscarCursoGestion', 'CursoController@buscarCursoGestion');
Route::get('/curso/listarCursoGestion', 'CursoController@listarCursoGestion');


Route::get('/gestion', 'GestionController@index');
Route::post('/gestion/registrar', 'GestionController@store');
Route::put('/gestion/desactivar', 'GestionController@desactivar');
Route::get('/gestion/obtenerCabecera', 'GestionController@obtenerCabecera');
Route::get('/gestion/obtenerDetalles', 'GestionController@obtenerDetalle');


Route::get('/alumno', 'AlumnoController@index');
Route::post('/alumno/registrar','AlumnoController@store');
Route::put('/alumno/actualizar','AlumnoController@update');
Route::put('/alumno/desactivar','AlumnoController@desactivar');
Route::put('/alumno/activar','AlumnoController@activar');

Route::get('/bimestre', 'BimestreController@index');
Route::post('/bimestre/registrar','BimestreController@store');
Route::put('/bimestre/actualizar','BimestreController@update');
Route::put('/bimestre/desactivar','BimestreController@desactivar');
Route::put('/bimestre/activar','BimestreController@activar');

Route::get('/paralelo', 'ParaleloController@index');
Route::post('/paralelo/registrar','ParaleloController@store');
Route::put('/paralelo/actualizar','ParaleloController@update');
Route::put('/paralelo/desactivar','ParaleloController@desactivar');
Route::put('/paralelo/activar','ParaleloController@activar');
Route::get('/paralelo/selectParalelo','ParaleloController@selectParalelo');

Route::get('/inscripcion', 'AlumnoController@index');
Route::post('/inscripcion/registrar', 'AlumnoController@store');
Route::put('/inscripcion/desactivar', 'AlumnoController@desactivar');
Route::get('/inscripcion/obtenerCabecera', 'AlumnoController@obtenerCabecera');
Route::get('/inscripcion/obtenerCabecera', 'AlumnoController@obtenerAlumno');
Route::get('/inscripcion/obtenerDetalles', 'AlumnoController@obtenerDetalle');

Route::get('/materia', 'MateriaController@index');
Route::post('/materia/registrar','MateriaController@store');
Route::put('/materia/actualizar','MateriaController@update');
Route::put('/materia/desactivar','MateriaController@desactivar');
Route::put('/materia/activar','MateriaController@activar');

Route::get('/gestionMaterias', 'CursoGestionController@mostrarCursosDadoGestion');
Route::get('/gestionMaterias/buscarCursoGestion', 'MateriaController@buscarCursoGestion');
Route::get('/gestionMaterias/listarCursoGestion', 'MateriaController@listarMateriaGestion');

});
// Auth::routes();
   
// Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
