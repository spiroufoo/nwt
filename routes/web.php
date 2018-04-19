<?php

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

$router->get('/api/compare/{owner1}/{repo1}/{owner2}/{repo2}', 'GithubController@compare');

$router->get('/api', 'GithubController@api');

$router->get('/', function ()  {
    return view('nwt', []);
});