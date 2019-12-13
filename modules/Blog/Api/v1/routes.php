<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group(['namespace' => 'Medom\Modules\Blog\Api\v1\Controllers'], function () use ($api) {
        // Account routes
        $api->group(['prefix' => 'blog'], function () use ($api) {
            $api->get('/', function () {

                return json_encode(['status' => 'Success', 'message' => 'Blog Api working']);
            });
            $api->post('/create', 'BlogController@createBlog')->middleware('auth')->middleware('admin');
            $api->post('/update/{id}', 'BlogController@updateBlog')->middleware('auth')->middleware('admin');
            $api->delete('/delete/{id}', 'BlogController@deleteBlog')->middleware('auth')->middleware('admin');
            $api->get('/all', 'BlogController@getAllBlogs');
            $api->get('/{id}/all', 'BlogController@getAllBlogsbyId');
            $api->get('/all/categorytype', 'BlogController@getbyCategory');



            $api->post('/create/category', 'BlogController@createBlogCategory')->middleware('auth')->middleware('admin');
            $api->post('/update/category/{id}', 'BlogController@updateCategory')->middleware('auth')->middleware('admin');
            $api->delete('/delete/category/{id}', 'BlogController@deleteCategory')->middleware('auth')->middleware('admin');
            $api->get('/all/category', 'BlogController@getAllCategory');
        });
    });
});
