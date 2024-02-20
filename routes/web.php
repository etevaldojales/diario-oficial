<?php
use App\Http\Controllers\DiarioController;
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
/*
Route::get('/', function () {
    return view('home');
});
*/
Route::get('/', 'App\Http\Controllers\DiarioController@index')->name('home');

Route::get('pdf-detalhe/{id}', 'App\Http\Controllers\DiarioController@gerarPdf')->name('diario-pdf');
Route::post('cadastro-json', 'App\Http\Controllers\DiarioController@store')->name('cadastro-json');
Route::post('getdados-json', 'App\Http\Controllers\DiarioController@getDados')->name('getdados-json');
Route::post('edit-json', 'App\Http\Controllers\DiarioController@edit')->name('edit-json');
Route::post('show-json', 'App\Http\Controllers\DiarioController@show')->name('show-json');
Route::post('delete-json', 'App\Http\Controllers\DiarioController@excluir')->name('delete-json');
