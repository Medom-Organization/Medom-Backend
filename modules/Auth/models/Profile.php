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
    protected $fillable = ['id', 'user_id', 'bookings', 'genotype', 'blood_group', ""];
    public $incrementing = false;
}
