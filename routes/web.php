<?php

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
    return phpinfo();
});

$router->get('/carts/{uuid}', 'App\Cart\CartController@getAction');
$router->post('/carts/products', 'App\Cart\CartController@addProductToCartAction');
$router->delete('/carts/products', 'App\Cart\CartController@deleteProductFromCartAction');
$router->get('/carts/products/{uuid}', 'App\Cart\CartController@getAllCartProductsAction');
$router->post('/carts', 'App\Cart\CartController@createCartAction');

$router->get('/products/{page}', 'App\ProductCatalog\ProductCatalogController@getAllPaginatedAction');
$router->post('/products', 'App\ProductCatalog\ProductCatalogController@addProductAction');
$router->patch('/products', 'App\ProductCatalog\ProductCatalogController@updateProductAction');
$router->delete('/products', 'App\ProductCatalog\ProductCatalogController@deleteProductAction');
