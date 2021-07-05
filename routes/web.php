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

use App\Mail\sendEmailMaillable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->POST('/sendEmail', 'NotifikasiController@sendEmail');
$router->POST('/sendWA', 'NotifikasiController@sendWA');

$router->get('/sendWA2', 'NotifikasiController@sendWaLangsung');


$router->get('/test', function () {
    Mail::send(new sendEmailMaillable);
});

$router->get('/queue', function () {
    //Artisan::call('migrate');
    Artisan::call('queue:work');
    //Illuminate\Support\Facades\Artisan::call('migrate');
});

$router->get('/setup', function () {
    Artisan::call('migrate');
});
