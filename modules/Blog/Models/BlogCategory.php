<?php

namespace Medom\Modules\Blog\Models;

// use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;


class BlogCategory extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', "description"];
}
