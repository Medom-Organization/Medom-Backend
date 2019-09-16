<?php

namespace Medom\Modules\Auth\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements
    JWTSubject,
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    // use Notifiable;
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['uid', 'first_name', 'last_name', 'email', 'role_id', 'password', 'role', 'profile_picture'];
    protected $hidden = ['password'];
    protected $with = ['role'];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function role()
    {
        return $this->hasOne(Role::class, '_id', 'role_id');
    }

    public function fullName()
    {
        return $this->first_name . " " . $this->last_name;
    }
    public function scopeType($query, $roles)
    {
        return $query->whereHas('role', function ($query) use ($roles) {
            return $query->whereIn('role_id', (array) $roles);
        });
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Travellab\Notifications\MailResetPasswordNotification($token));
    }
}
