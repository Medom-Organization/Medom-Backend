<?php
namespace Medom\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;


class Role extends Model
{

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','name', 'display_name',"description"];
    public $incrementing = false;
   
}