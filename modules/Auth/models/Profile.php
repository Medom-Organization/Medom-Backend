<?php

namespace Medom\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;


class Profile extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'phone_no', 'marital_status', 'DOB', 'address', 'bookings', 'genotype', 'blood_group', 'wallet', 'height', 'weight', 'religion', 'next of kin', "allergies"];
    public $incrementing = false;
}
