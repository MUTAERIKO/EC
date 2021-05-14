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


Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('goods/create','Admin\GoodsController@add');
    Route::post('goods/create','Admin\GoodsController@create');
    Route::get('goods','Admin\GoodsController@index')->name('index');
    Route::get('goods/show/','Admin\GoodsController@show')->name('goodshow');
    Route::get('goods/mypage','Admin\GoodsController@mypage')->name('mypage');
    Route::post('goods/goods_user/{goods}','Admin\GoodsController@goods_user')->name('goods_user');
    Route::post('goods/goods_user_off/{goods}','Admin\GoodsController@goods_user_off')->name('goods_user_off');

    Route::get('goods/edit/{id}','Admin\GoodsController@edit')->name('goodsedit');
    Route::post('goods/edit','Admin\GoodsController@update');
    Route::post('goods/comment','Admin\GoodsController@comment');
    
    Route::get('goods/delete','Admin\GoodsController@delete');
    Route::get('goods/commentdelete/','Admin\GoodsController@commentdelete');
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
