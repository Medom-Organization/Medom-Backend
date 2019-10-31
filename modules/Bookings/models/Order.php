<?php

namespace Medom\Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'id',
        'booking_id',
        'first_name',
        'surname',
        'email',
        'phone',
        'amount',
        'currency',
        'price_info',
        'status',
        'user_id',
        'hospital_id',
        'date',
        'time'
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
