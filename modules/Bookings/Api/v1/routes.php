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
            // Order routes
            $api->group(['prefix' => 'order'], function () use ($api) {
                $api->post('/new', 'OrderController@newOrder')->middleware('auth:api');
                $api->get('/list', 'OrderController@listOrders');
                $api->get('{id}/all', 'OrderController@listOrdersbyUserId')->middleware('auth')->middleware('admin');
                $api->get('user/{id}/all', 'OrderController@listOrdersbyId');
                $api->get('/user', 'OrderController@listOrdersbyUser')->middleware('auth:api');
                $api->post('/filter', 'OrderController@filterorderbyUser')->middleware('auth:api');

                $api->post('/payment/new', 'OrderController@newPayment');
                $api->get("/payment/verify/{ref}", 'OrderController@verifyPayment');
                $api->get("/payment/all", 'OrderController@allPayment');

                // $api->post('/create-ticket', 'OrderController@createTicket');
                // $api->post('/confirm-booking/{orderId}', 'OrderController@confirmBooking');
            });
        });
    });
});
