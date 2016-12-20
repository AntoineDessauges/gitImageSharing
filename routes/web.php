<?php
/**
 * @var $router \Illuminate\Routing\Router
 */
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

$router->get('/home',["as"=>"home","uses"=>"HomeController@home"]);
$router->get('/',["as"=>"welcome","uses"=>"HomeController@welcome"])->middleware("guest");

//auth routes
$router->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$router->post('login', 'Auth\LoginController@login');
$router->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$router->get('register', 'Auth\RegisterController@showRegistrationForm');
$router->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$router->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
$router->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
$router->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
$router->post('password/reset', 'Auth\ResetPasswordController@reset');

//albums
$router->resource("album","AlbumController");

//images
$router->resource('image','ImageController',["except"=>["store"]]);
$router->get('/image/{image}/raw',["as"=>"image.raw","uses"=>'ImageController@raw']);
$router->get('/image/{image}/thumbnail',["as"=>"image.thumbnail","uses"=>'ImageController@thumbnail']);
$router->post('/upload/image',["as"=>"image.upload",'uses'=>'UploadController@upload']);
$router->get('/upload/image',["as"=>"image.store_2",'uses'=>'ImageController@create']);

$router->resource("image.comment",'CommentController',["except"=>"create","update","edit"]);