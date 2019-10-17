<?php

namespace Medom\Modules\Hospitals\Models;

use Illuminate\Database\Eloquent\Model;


class HospitalProfessional extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'hospital_id', 'role_id'];
}
