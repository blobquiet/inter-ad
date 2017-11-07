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
    return view('dashboard');
})->middleware('auth');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
// Route::get('/system-management/{option}', 'SystemMgmtController@index');
Route::get('/profile', 'ProfileController@index');

Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');
Route::resource('user-management', 'UserManagementController');

Route::resource('cliente-management', 'ClienteManagementController');
Route::post('cliente-management/search', 'ClienteManagementController@search')->name('cliente-management.search');

Route::resource('promocion-management', 'PromocionManagementController');
Route::post('promocion-management/search', 'PromocionManagementController@search')->name('promocion-management.search');

Route::resource('estadoprom-management', 'EstadoPromManagementController');
Route::post('estadoprom-management/search', 'EstadoPromManagementController@search')->name('estadoprom-management.search');

Route::resource('system-management/pais', 'PaisController');
Route::post('system-management/pais/search', 'PaisController@search')->name('pais.search');

Route::resource('system-management/departamento', 'DepartamentoController');
Route::post('system-management/departamento/search', 'DepartamentoController@search')->name('departamento.search');

Route::resource('system-management/ciudad', 'CiudadController');
Route::post('system-management/ciudad/search', 'CiudadController@search')->name('ciudad.search');

Route::resource('system-management/empresa', 'EmpresaController');
Route::post('system-management/empresa/search', 'EmpresaController@search')->name('empresa.search');

Route::resource('system-management/evento', 'EventoController');
Route::post('system-management/evento/search', 'EventoController@search')->name('evento.search');

Route::get('system-management/report', 'ReportController@index');
Route::post('system-management/report/search', 'ReportController@search')->name('report.search');
Route::post('system-management/report/excel', 'ReportController@exportExcel')->name('report.excel');
Route::post('system-management/report/pdf', 'ReportController@exportPDF')->name('report.pdf');

Route::get('avatars/{name}', 'EmployeeManagementController@load');
Route::get('avatars/{name}', 'PromocionManagementController@load');
Route::get('avatars/{name}', 'ClienteManagementController@load');
