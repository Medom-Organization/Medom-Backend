<?php

namespace Medom\Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'booking_id',
        'first_name',
        'surname',
        'email',
        'phone',
        'amount',
        'currency',
        'price_info',
        'free_baggages',
        'departure_leg',
        'return_leg',
        'booking_reference',
        'pnr',
        'ticket_time_limit',
        'total_travellers',
        'traveller_stats',
        'travellers',
        'from',
        'to',
        'departure_city',
        'destination_city',
        'departure_date',
        'return_date',
        'status',
        'user_id'
    ];

    // public function flight()
    // {
    //     return $this->hasOne('\Travellab\Modules\Booking\Models\FLight');
    // }


    //    public function getFromAttribute($from){
    //
    //        var_dump($from);
    ////        $airline = AmadeusAirline::find($from->id);
    //
    //      return  (object) ["airline",$from];
    //
    //    }


    //    public function getToAttribute($to){
    //        $airline = AmadeusAirline::find($to->id);
    //
    //
    //      return   (object) ["airline"=>$airline,$to];
    //    }









}
