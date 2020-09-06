<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session as FacadesSession;

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

Route::get('/test', function () {
    return view('admin.pages.index');
});

Route::get('/locale/{locale}',function($locale){
    FacadesSession::put('locale',$locale);
    return redirect()->back();
});

Route::group(['prefix' => 'manager'], function () {

    Route::get('locale/{locale}',function($locale){
        // dd($locale);
        FacadesSession::put('locale',$locale);
        return redirect()->back();
    });
});