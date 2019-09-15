<?php

namespace Medom\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;


class Hospitals extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['_id', 'name', 'display_name', "description"];
}
