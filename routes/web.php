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


// SSLCOMMERZ Start
Route::get('/example1', 'SslCommerzPaymentController@exampleEasyCheckout');
Route::get('/example2', 'SslCommerzPaymentController@exampleHostedCheckout');
Route::get('/pay', 'SslCommerzPaymentController@index');
Route::get('/pay-via-ajax', 'SslCommerzPaymentController@payViaAjax');
Route::get('/success', 'SslCommerzPaymentController@success');
Route::get('/fail', 'SslCommerzPaymentController@fail');
Route::get('/cancel', 'SslCommerzPaymentController@cancel');
Route::get('/ipn', 'SslCommerzPaymentController@ipn');


Route::get('/', 'PagesController@index')->name('index');

Route::get('/books/search', 'BooksController@search')->name('books.search');

Route::get('/books/advance_search', 'BooksController@advancesearch')->name('books.searched.advance');

//Books Routs For Frontend

Route::get('/book', 'BooksController@index')->name('books.index');
Route::get('/books/{slug}', 'BooksController@show')->name('books.show');
Route::get('/books/upload/new', 'BooksController@create')->name('books.upload');
Route::post('/books/store', 'BooksController@store')->name('books.store');

// User Routes 

Route::get('/books/categories/{slug}', 'CategoriesController@show')->name('categories.show');

Route::group(['prefix' => 'users'], function () {
    Route::get('/profile/{username}', 'UsersController@profile')->name('users.profile');
    Route::get('/profile/{username}/books', 'UsersController@books')->name('users.books');
});

Route::get('/wishlist/book', 'WishlistController@wishlist')->name('wishlist');
Route::get('/wishlist/test/{user_id}', 'WishlistController@wishlist_test')->name('wishlist_test');




//Wishlish Route
Route::get('/book/wishlist/{id}', [
    'uses' => 'WishlistController@wishlist_add',
    'as' => 'wishlist_add'
]);


// Route::get('/books/wishlist', [
//     'uses' => 'WishlistController@wishlist',
//     'as' => 'wishlist'
// ]);

Route::get('/wishlist/remove/{id}', [
    'uses' => 'WishlistController@wishlist_remove',
    'as' => 'wishlist_remove'
]);

// Dashboard Routes For Authenticate Users
Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', 'DashboardController@index')->name('users.dashboard');
    Route::get('/books', 'DashboardController@books')->name('users.dashboard_books');
    Route::get('/books/edit/{slug}', 'DashboardController@bookEdit')->name('users.dashboard.books.edit');
    Route::post('/books/update/{slug}', 'DashboardController@bookUpdate')->name('users.dashboard.books.update');
    Route::post('/books/delete/{slug}', 'DashboardController@bookDelete')->name('users.dashboard.books.delete');


    // Book Request Routes
    Route::get('/books/request_list', 'DashboardController@bookRequestlist')->name('books.request.list');
    Route::post('/books/request/{slug}', 'DashboardController@bookRequest')->name('books.request');
    Route::post('/books/request/update/{slug}', 'DashboardController@bookRequestupdate')->name('books.request.update');
    Route::post('/books/request/delete/{slug}', 'DashboardController@bookRequestdelete')->name('books.request.delete');
    Route::post('/books/request_approve/{id}', 'DashboardController@bookRequestapprove')->name('books.request.approve');
    Route::post('/books/request_reject/{id}', 'DashboardController@bookRequestreject')->name('books.request.reject');
    // Book return
    Route::post('/books/order_return/{id}', 'DashboardController@bookorderreturn')->name(' books.return.store');
    Route::post('/books/order_return_confirm/{id}', 'DashboardController@bookorderreturnconfirm')->name('books.return');



    // Book Order Routes 
    Route::get('/books/order_list', 'DashboardController@bookordertlist')->name('books.order.list');

    Route::post('/books/order_approve/{id}', 'DashboardController@bookorderapprove')->name('books.order.approve');
    Route::post('/books/order_reject/{id}', 'DashboardController@bookorderreject')->name('books.order.reject');
});
//Admin Routes

Route::group(['prefix' => 'adminn'], function () {
    Route::get('/', 'Backend\PagesController@index')->name('admin.index');
    // Admin Login Routes
    Route::get('/login', 'Auth\Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Auth\Admin\LoginController@login')->name('admin.login.submit');
    Route::post('/logout/submit', 'Auth\Admin\LoginController@logout')->name('admin.logout');

    // Password Email Send
    Route::get('/password/reset', 'Auth\Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/resetPost', 'Auth\Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');

    // Password Reset
    Route::get('/password/reset/', 'Auth\Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('/password/reset', 'Auth\Admin\ResetPasswordController@reset')->name('admin.password.reset.post');


    Route::group(['prefix' => 'books'], function () {
        Route::get('/', 'Backend\BooksController@index')->name('admin.books.index');

        Route::get('/unapprove', 'Backend\BooksController@unapprove')->name('admin.books.unapprove');
        Route::get('/approve/book', 'Backend\BooksController@approvebook')->name('admin.books.approved');

        Route::post('/approve{id}', 'Backend\BooksController@approve')->name('admin.books.approve');
        Route::post('/unapprove{id}', 'Backend\BooksController@unapprovebook')->name('admin.books.unapproved');


        // Route::get('/{id}', 'Backend\BooksController@index')->name('admin.books.show');
        Route::get('/create', 'Backend\BooksController@create')->name('admin.books.create');
        Route::get('/edit{id}', 'Backend\BooksController@edit')->name('admin.books.edit');
        Route::post('/store', 'Backend\BooksController@store')->name('admin.books.store');
        Route::post('/update{id}', 'Backend\BooksController@update')->name('admin.books.update');

        Route::post('/delete{id}', 'Backend\BooksController@destroy')->name('admin.books.delete');
    });
    //Authors Routes
    Route::group(['prefix' => 'authors'], function () {
        Route::get('/', 'Backend\AuthorsController@index')->name('admin.authors.index');
        Route::get('/{id}', 'Backend\AuthorsController@index')->name('admin.authors.show');
        Route::post('/store', 'Backend\AuthorsController@store')->name('admin.authors.store');
        Route::post('/update{id}', 'Backend\AuthorsController@update')->name('admin.authors.update');
        Route::post('/delete{id}', 'Backend\AuthorsController@destroy')->name('admin.authors.delete');
    });
    //categories Routes

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'Backend\CategoriesController@index')->name('admin.categories.index');
        Route::get('/{id}', 'Backend\CategoriesController@index')->name('admin.categories.show');
        Route::post('/store', 'Backend\CategoriesController@store')->name('admin.categories.store');
        Route::post('/update{id}', 'Backend\CategoriesController@update')->name('admin.categories.update');
        Route::post('/delete{id}', 'Backend\CategoriesController@destroy')->name('admin.categories.delete');
    });
    //Publishers Routes

    Route::group(['prefix' => 'publishers'], function () {
        Route::get('/', 'Backend\PublilshersController@index')->name('admin.publishers.index');
        Route::get('/{id}', 'Backend\PublilshersController@index')->name('admin.publishers.show');
        Route::post('/store', 'Backend\PublilshersController@store')->name('admin.publishers.store');
        Route::post('/update{id}', 'Backend\PublilshersController@update')->name('admin.publishers.update');
        Route::post('/delete{id}', 'Backend\PublilshersController@destroy')->name('admin.publishers.delete');
    });
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
