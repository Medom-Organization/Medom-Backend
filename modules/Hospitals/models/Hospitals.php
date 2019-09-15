<?php

namespace Medom\Modules\Hospitals\Models;

use Illuminate\Database\Eloquent\Model;


class Hospitals extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'hospital_name', 'email', "address", 'phone_no', 'certificate_no', 'logo', 'user_id'];
}
