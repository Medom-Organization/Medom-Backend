<?php

namespace Medom\Modules\Auth\Api\v1\Transformers;

use League\Fractal;
use Medom\Modules\Auth\Models\User;

class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(User $user)
    {
        return [
          'id'=>$user->id,
          'first_name'=>$user->first_name,
          'last_name'=>$user->last_name,
          'email'=>$user->email,
          'name'=>$user->fullName(),
          'role'=>$user->role,
          
        ];
    }

}