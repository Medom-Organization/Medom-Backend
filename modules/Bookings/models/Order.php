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
        'booking_type',
        'description',
        'date',
        'time'
    ];
}
