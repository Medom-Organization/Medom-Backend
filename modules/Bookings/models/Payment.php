<?php

namespace Medom\Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'currency',
        'reference',
        'name',
        'status'
    ];


    public function order()
    {
        return $this->belongsTo('Medom\Modules\Booking\Models\Order');
    }
}
