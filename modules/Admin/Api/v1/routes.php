<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group(['namespace' => 'Medom\Modules\Admin\Api\v1\Controllers'], function () use ($api) {
        // Admin routes
        $api->group(['prefix' => 'admin'], function () use ($api) {
            $api->get('/', function () {

                return json_encode(['status' => 'Success', 'message' => 'Admin Api working']);
            });
            $api->post('/login', 'AdminController@login');
            $api->get('/users/all', 'AdminController@getUsers');
            $api->get('/user/roles', 'AdminController@getUsersType')->middleware('auth:api');
            $api->get('/roles', 'AdminController@getRoles')->middleware('auth:api');
            $api->get('/metrics', 'AdminController@metrics')->middleware('auth:api');
            $api->post('/addemployee', 'AdminController@addEmployee')->middleware('auth:api');
            $api->delete('/delete/{id}', 'AdminController@delete')->middleware('auth:api');
            $api->post('/update/profile', 'AdminController@updateProfile')->middleware('auth:api');
            $api->post('/update/employee/{id}', 'AdminController@updateProfilebyId')->middleware('auth:api');
        });
    });
});
