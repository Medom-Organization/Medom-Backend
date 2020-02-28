<?php

namespace Medom\Modules\Auth\Api\v1\Transformers;

use League\Fractal;
use Medom\Modules\Auth\Models\User;

class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(User $user)
    {
        // dd($user->profile_picture);
        $photos = collect($user->profile_picture)->pluck('profile_picture');
        $photos = $photos->map(function ($image) {
            return url('storage/' . $image);
        });
        $photos = url('storage/' . $user->profile_picture);
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'surname' => $user->surname,
            'email' => $user->email,
            'name' => $user->fullName(),
            'role' => $user->role,
            'profile_picture' => $photos,

        ];
    }
}
