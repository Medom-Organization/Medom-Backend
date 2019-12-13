<?php

namespace Medom\Modules\Blog\Models;

// use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;
use Medom\Modules\Blog\Models\BlogPhotos;


class Blog extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'truncated', 'content', 'category_id', "status"];
    // protected $with = ['category_id'];
    public function photo()
    {
        return $this->hasMany(BlogPhotos::class, 'photo');
    }
    public function tag()
    {
        return $this->hasMany(BlogTags::class, 'tag');
    }
    public function category()
    {
        return $this->hasOne(BlogCategory::class, 'name');
    }
}
