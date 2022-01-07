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

// Routes for blog guests
//Route::get('/', 'PagesController@getIndex');
Route::get('/', 'PostController@index');

Route::get('about', 'PagesController@getAbout');  

Route::get('contact', 'PagesController@getContact'); 
Route::post('contact', 'PagesController@postContact');          // to send the email from Contact Me form


// Routes for Posts
Route::resource('post', 'PostController');
Route::get('search', 'PostController@search')->name('post.search');
Route::get('category-posts/{category_id}', 'PostController@getPostsForCategory')->name('posts.category');


// Authentication
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'PostController@showAdminPanel')->name('home');

// Comments
Route::post('comments/{post_id}', 'CommentsController@store')->name('comment.store');
Route::get('comments', 'CommentsController@index')->name('comments.index');
Route::get('comments/{comment_id}', 'CommentsController@approve_comment')->name('comment.approve');
Route::delete('comments/{comment_id}', 'CommentsController@destroy')->name('comment.delete');

// Categories
Route::resource('categories', 'CategoryController');

