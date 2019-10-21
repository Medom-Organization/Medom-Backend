<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group(['namespace' => 'Medom\Modules\Bookings\Api\v1\Controllers'], function () use ($api) {
        // Account routes
        $api->group(['prefix' => 'bookings'], function () use ($api) {
            $api->get('/', function () {

                return json_encode(['status' => 'Success', 'message' => 'Booking Api working']);
            });
            // $api
        });
    });
});
