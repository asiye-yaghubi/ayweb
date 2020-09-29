<?php

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
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
    // return view('welcome');
    $category = Category::find(7);
    $tags = $category->tag;
    dd($tags);

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function () {
    return view('admin.pages.index');
});


Route::group(['prefix' => 'manage','namespace' => 'Admin'], function () {

    Route::get('locale/{locale}',function($locale){
        FacadesSession::put('locale',$locale);
        return redirect()->back();
    });
    Route::resource('permission', 'PermissionController');
    Route::resource('role', 'RoleController');
    Route::resource('user', 'UserController');
    Route::post('user/update', 'UserController@update')->name('user.update');
    Route::resource('category', 'CategoryController');
    Route::post('category/update', 'CategoryController@update')->name('category.update');
    Route::resource('tag', 'TagController');
    Route::resource('post', 'PostController');


    




});