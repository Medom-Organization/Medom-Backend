<?php

namespace Medom\Modules\Hospitals\Models;

use Illuminate\Database\Eloquent\Model;


class Settingshospital extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['hid', 'hospitalname'];
}
