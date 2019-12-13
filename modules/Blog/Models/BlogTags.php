<?php

namespace Medom\Modules\Blog\Models;

// use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;


class BlogTags extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['blog_id', 'tag'];
}
