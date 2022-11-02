<?php

use Illuminate\Support\Str;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/register', 'UserController@register');
$router->post('/login', 'UserController@login');
$router->get('/category', 'CategoryController@index');
$router->get('/category/{slug}', 'CategoryController@show');

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/profile', 'UserController@show');
    $router->post('/profile', 'UserController@update');
    $router->delete('/profile', 'UserController@delete');
});

$router->group(['middleware' => 'auth'], function () use ($router) {

    $router->post('/logout', 'UserController@logout');

    $router->group(['prefix' => 'category'], function () use ($router) {
        $router->group(['middleware' => 'admin'], function () use ($router) {
            $router->post('/', 'CategoryController@store');
            $router->put('/{slug}', 'CategoryController@update');
            $router->delete('/{slug}', 'CategoryController@delete');
        });
    });

    $router->group(['prefix' => 'product', 'middleware' => ''], function () use ($router) {
        $router->get('/', 'ProductController@index');
        $router->get('/{slug}', 'ProductController@show');

        $router->group(['middleware' => 'seller'], function () use ($router) {
            $router->post('/', 'ProductController@store');
            $router->put('/{slug}', 'ProductController@update');
            $router->delete('/{slug}', 'ProductController@delete');
        });
    });

    $router->group(['prefix' => 'order'], function () use ($router) {
        $router->get('/', 'OrderController@index');
        $router->get('/{slug}', 'OrderController@show');

        $router->group(['middleware' => 'buyer'], function () use ($router) {
            $router->post('/', 'OrderController@store');
            $router->put('/{slug}', 'OrderController@update');
            $router->delete('/{slug}', 'OrderController@delete');
        });
    });

    $router->group(['prefix' => 'billing'], function () use ($router) {
        $router->get('/{slug}', 'BillingController@show');
        $router->post('/', ['middleware' => 'buyer', 'uses' => 'BillingController@store']);
    });
});
