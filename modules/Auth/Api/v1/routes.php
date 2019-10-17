<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group(['namespace' => 'Medom\Modules\Auth\Api\v1\Controllers'], function () use ($api) {
        // Account routes
        $api->group(['prefix' => 'auth'], function () use ($api) {
            $api->get('/', function () {

                return json_encode(['status' => 'Success', 'message' => 'Auth Api working']);
            });
            $api->post('/login', 'AuthController@login');
            $api->post('/user/register', 'AuthController@registerUser');
            $api->post('/hospital/register', 'AuthController@registerHospital');
        });
    });



    $api->group(['namespace' => 'Medom\Modules\Admin\Api\v1\Controllers'], function () use ($api) {
        // Admin routes
        $api->group(['prefix' => 'admin'], function () use ($api) {
            $api->get('/', function () {

                return json_encode(['status' => 'Success', 'message' => 'Admin Api working']);
            });
                $api->post('/login', 'AdminController@login');
                $api->get('/users/all', 'AdminController@getUsers');
                $api->get('/roles', 'AdminController@getRoles');
                $api->post('/addemployee', 'AdminController@addSuperAdmin')->middleware('auth:api');
                $api->post('/update/profile', 'AdminController@updateProfile')->middleware('auth:api');
        });
    });
});
