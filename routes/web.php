<?php

use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
    // $user = Auth::user();
    $user = auth()->user();
    $u = User::find($user->id);
    $photo = new Image();
    $photo->url = 'lllll';
    $u->images()->save($photo);
    dd($user->id);
    return view('welcome');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/test', function () {
//     return view('admin.pages.index');
// });


Route::group(['prefix' => 'manage','middleware'=>['auth','UserLevel'],'namespace' => 'Admin'], function () {

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
    Route::post('post/update', 'PostController@update')->name('post.update');
    Route::get('post/description/{post}', 'PostController@createDescription')->name('post.description');
    Route::post('post/uploadImage', 'PostController@uploadImage')->name('upload');

    Route::post('post/description', 'PostController@saveDescription')->name('save.description');
    Route::get('post/show/description/{post}', 'PostController@showDescription')->name('show.description');


    Route::resource('profile', 'ProfileController');

    Route::post('change-profile', 'ProfileController@changeImage')->name('change-profile');


    




});
Route::get('/userpanel', 'HomeController@userpanel');