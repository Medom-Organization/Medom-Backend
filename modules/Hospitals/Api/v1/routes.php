<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group(['namespace' => 'Medom\Modules\Hospitals\Api\v1\Controllers'], function () use ($api) {
        // Account routes
        $api->group(['prefix' => 'hospital'], function () use ($api) {
            $api->get('/', function () {

                return json_encode(['status' => 'Success', 'message' => 'Hospital Api working']);
            });
            $api->post('/add/hospitaladmin', 'HospitalController@addHospitalAdmin')->middleware('auth')->middleware('hospitaladmin');
            $api->post('/add/staff', 'HospitalController@addHospitalStaff')->middleware('auth')->middleware('hospitaladmin');
            $api->post('/add/professional/{id}', 'HospitalController@addHospitalProfessional')->middleware('auth')->middleware('hospitaladmin');
            $api->get('/professional/all', 'HospitalController@getAllProfessionals');
            $api->get('/staffs/all', 'HospitalController@getAllStaffs')->middleware('auth')->middleware('hospitaladmin');
            $api->get('/bookings/all', 'HospitalController@getAllHospitalsBooking')->middleware('auth');
            $api->post('/professional/register', 'HospitalController@registerProfessional')->middleware('auth');
            $api->get('/all', 'HospitalController@getHospitals');
        });
    });


});
