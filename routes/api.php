<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prefix('pessoas')->group(function () {
//     Route::get('/', 'PessoaController@index');
//     Route::get('/{pessoa}', 'PessoaController@show');
//     Route::put('/{pessoa}/endereco', 'PessoaController@atualizarEndereco');
// });
Route::get('/pessoas/enderecos', 'PessoaController@withAddress');
Route::resource('/pessoas', 'PessoaController');
Route::resource('/enderecos', 'EnderecoController');
