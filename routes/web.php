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

Route::get('/', 'HomeController@index');

// маршрут для отдельного поста
Route::get('/post/{slug}', 'HomeController@show')->name('post.show');

// маршрут для вывода постов по тегу
Route::get('/tag/{slug}', 'HomeController@tag')->name('tag.show');

// маршрут для вывода постов по категории
Route::get('/category/{slug}', 'HomeController@category')->name('category.show');





Route::group(['middleware' => 'auth'], function (){
    Route::get('/profile', 'ProfileController@index');
    Route::post('/profile', 'ProfileController@store');
    Route::get('/logout', 'AuthController@logout');
    Route::post('comment', 'CommentsController@store');
});

Route::group(['middleware' => 'guest'], function (){
    Route::get('/register', 'AuthController@registerForm');
    Route::post('/register', 'AuthController@register');
    Route::get('/login', 'AuthController@loginForm')->name('login');
    Route::post('/login', 'AuthController@login');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {

    Route::get('/', 'DashboardController@index')->name('index');
    Route::resource('/categories', 'CategoriesController');
    Route::resource('/tags', 'TagsController');
    Route::resource('/users', 'UsersController');
    Route::resource('/posts', 'PostsController');

});
