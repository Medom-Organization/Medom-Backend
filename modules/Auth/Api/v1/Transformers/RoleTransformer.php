<?php

namespace Rent\Modules\Auth\Api\v1\Transformers;

use League\Fractal;
use Rent\Modules\Auth\Models\Role;

class RoleTransformer extends Fractal\TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id' => $role->_id,
            'name' => $role->display_name,
        ];
    }

}