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

Route::post('/upload', 'DocViewerAPI@up')->name('up');
Route::get('/DOCSAPI/down', 'DocViewerAPI@down')->name('down');
Route::get('/DOCSAPI/details', 'DocViewerAPI@detail')->name('detail');
Route::get('/DOCS', 'DocViewer@index')->name('doc');
Route::get('/DOCSAPI', 'DocViewerAPI@search')->name('docAPI');
Route::get('/upload', 'DocViewer@upload')->name('load');
