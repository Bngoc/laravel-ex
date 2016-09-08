<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

View::share('title', 'Admin - Khoa Phạm');

/*
/ Admin
*/
Route::get('/admin', 'AdminController@index');
// middleware => 'auth' de bat dang nhap truoc khi thuc hien
Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {

    Route::get('/logout', ['as' => 'admin.logout', 'uses' => 'AdminController@getLogout']);

    Route::group(['prefix' => 'cate'], function () {
        Route::get('/list', ['as' => 'admin.cate.list', 'uses' => 'CateController@getlist']);
        Route::get('/add', ['as' => 'admin.cate.getAdd', 'uses' => 'CateController@getAdd']);
        Route::post('/add', ['as' => 'admin.cate.postAdd', 'uses' => 'CateController@postAdd']);
        Route::get('/delele/{id}', ['as' => 'admin.cate.getDelete', 'uses' => 'CateController@getDelete']);
        Route::get('/edit/{id}', ['as' => 'admin.cate.getEdit', 'uses' => 'CateController@getEdit']);
        Route::post('/edit/{id}', ['as' => 'admin.cate.postEdit', 'uses' => 'CateController@postEdit']);
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('add', ['as' => 'admin.product.getAdd', 'uses' => 'ProductController@getAdd']);
        Route::post('add', ['as' => 'admin.product.postAdd', 'uses' => 'ProductController@postAdd']);
        Route::get('list', ['as' => 'admin.product.list', 'uses' => 'ProductController@getList']);
        Route::get('delete/{_id}', ['as' => 'admin.product.getDelete', 'uses' => 'ProductController@getDelete']);
        Route::get('edit/{id}', ['as' => 'admin.product.getEdit', 'uses' => 'ProductController@getEdit']);
        Route::post('edit/{id}', ['as' => 'admin.product.postEdit', 'uses' => 'ProductController@postEdit']);
        Route::get('delimg/{id}', ['as' => 'admin.product.getDelImg', 'uses' => 'ProductController@getDelImg']);
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('add', ['as' => 'admin.user.getAdd', 'uses' => 'AdminController@getAdd']);
        Route::post('add', ['as' => 'admin.user.postAdd', 'uses' => 'AdminController@postAdd']);
        Route::get('list', ['as' => 'admin.user.list', 'uses' => 'AdminController@getList']);
        Route::get('delete/{_id}', ['as' => 'admin.user.getDelete', 'uses' => 'AdminController@getDelete']);
        Route::get('edit/{id}', ['as' => 'admin.user.getEdit', 'uses' => 'AdminController@getEdit']);
        Route::post('edit/{id}', ['as' => 'admin.user.postEdit', 'uses' => 'AdminController@postEdit']);
    });
    Route::group(['prefix' => 'musthave'], function () {
        Route::get('add', ['as' => 'must.getAdd', 'uses' => 'MustHaveController@getAdd']);
        Route::post('add', ['as' => 'must.postAdd', 'uses' => 'MustHaveController@postAdd']);
        Route::get('delete/{id}', ['as' => 'must.getDel', 'uses' => 'MustHaveController@getDel']);
        Route::get('edit/{id}', ['as' => 'must.getEdit', 'uses' => 'MustHaveController@getEdit']);
        Route::post('edit/{id}', ['as' => 'must.postEdit', 'uses' => 'MustHaveController@postEdit']);
        Route::get('list', ['as' => 'must.list', 'uses' => 'MustHaveController@getlist']);
    });
});

//Route::get('home', ['middleware' => 'admin', 'uses' => 'WelcomeController@index']);
//Route::get('home', 'HomeController@index');

//Pass Reset  - email
Route::get('password/email/{token?}', ['as' => 'password/email', 'uses' => 'Auth\PasswordController@getEmail']);
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Route::get('password/email/{token?}', 'Auth\PasswordController@showResetForm');
// Route::post('password/email', 'Auth\PasswordController@sendResetLink');
//Route::post('password/reset', 'Auth\PasswordController@resetPassword');

//Register -
Route::get('auth/register', ['as' => 'auth/register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('auth/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);

// // Registration Routes...
// Route::get('admin/register', 'Admin\AuthController@showRegistrationForm');
// Route::post('admin/register', 'Admin\AuthController@register');
//

// web luu cookies
Route::group(['middleware' => 'web'], function () {
    //Route::auth();

    //Login Routes...
    Route::get('admin/login', 'Admin\AuthController@getLogin');
    Route::post('admin/login', 'Admin\AuthController@postLogin');

    //Route::get('/home', 'HomeController@index');
});

Route::get('/', ['as' => 'home', 'uses' => 'WelcomeController@index']);

//cac danh muc san pham
Route::get(
    'danh-muc/{categories}',
    array('as' => 'category_page', 'uses' => 'WelcomeController@showproduct')
);
Route::get(
    'danh-muc/{categories}/{products}',
    array('as' => 'product_page', 'uses' => 'WelcomeController@showproduct')
);
Route::get(
    'danh-muc/{categories}/{products}/{sections}',
    array('as' => 'sections_page', 'uses' => 'WelcomeController@showproduct')
);

Route::get(
    'san-pham/{alias}/{id}',
    array('as' => 'section', 'uses' => 'WelcomeController@showdetail')
)
    ->where('id', '[0-9]+');

Route::get('/search', ['as' => 'search', 'uses' => 'SearchController@getSearch']);

// danh muc lien he
Route::get(
    'lien-he',
    array('as' => 'getlienhe', 'uses' => 'WelcomeController@getlienhe')
);
Route::post(
    'lien-he',
    array('as' => 'postlienhe', 'uses' => 'WelcomeController@postlienhe')
);

// Shopping cart
Route::get('/cart', ['as' => 'getCart', 'uses' => 'ShoppingCartController@getCart']);
Route::post('/cart', ['as' => 'postCart', 'uses' => 'ShoppingCartController@postCart']);
Route::post('editcart', ['as' => 'postEditCart', 'uses' => 'ShoppingCartController@postEditCart']);
Route::get('detelecart/{id}', ['as' => 'postDelCart', 'uses' => 'ShoppingCartController@getDelCart']);
Route::post('color-size-soluong', ['as' => 'color-size-soluong', 'uses' => 'ShoppingCartController@getCountPro']);
Route::get('clearcart', ['as' => 'getclearcart', 'uses' => 'ShoppingCartController@getClearCart']);

Route::get('detelecart/{id}', ['as' => 'postDelCart', 'uses' => 'ShoppingCartController@getDelCart']);
